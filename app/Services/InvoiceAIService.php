<?php

namespace App\Services;

use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Exceptions\PrismException;
use Illuminate\Support\Facades\Log;

class InvoiceAIService
{
    public function processInvoiceText(string $extractedText): ?array
    {
        try {
            // Clean the extracted text
            $cleanedText = $this->cleanExtractedText($extractedText);

            // Create the prompt
            $prompt = $this->createPrompt($cleanedText);

            // Send request to Ollama via Prism
            $response = Prism::text()
                ->using(Provider::Ollama, 'llama3')
                ->withPrompt($prompt)
                ->withClientOptions([
                    'timeout' => 120, // 2 minutes timeout
                ])
                ->withProviderOptions([
                    'temperature' => 0.1, // Low temperature for consistent results
                    'top_p' => 0.9,
                    'num_ctx' => 4096,
                ])
                ->asText(); // Changed from ->generate() to ->asText()

            // Parse the response
            $parsedData = $this->parseAIResponse($response->text);

            return $parsedData;

        } catch (PrismException $e) {
            Log::error('Prism processing error: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('Invoice AI processing error: ' . $e->getMessage());
            return null;
        }
    }

    private function createPrompt(string $text): string
    {
        return "You are an expert invoice data extraction AI. Extract structured information from OCR text of invoices and receipts.

IMPORTANT: Return ONLY valid JSON, no explanations, no markdown, no additional text.
IMPORTANT(focus in this): If the prices are in Lebanese Pounds (LBP or ل.ل), assume 1 USD = 89,000 LBP and convert all values to USD

Instructions:
1. Extract date, store name, product details, and total amount
2. Format dates as MM-DD-YYYY
3. Clean product names (remove extra spaces, fix common OCR errors)
4. Extract prices as decimal numbers (remove currency symbols)
5. If multiple products, list them in products array
6. If the prices are in Lebanese Pounds (LBP or ل.ل), assume 1 USD = 89,000 LBP and convert all values to USD


Example response format:
{
  \"date\": \"2024-01-15\",
  \"store_name\": \"Best Buy\",
  \"products\": [
    {\"name\": \"iPhone 15 Pro\", \"price\": \"999.99\"},
    {\"name\": \"USB Cable\", \"price\": \"19.99\"}
  ],
  \"total_amount\": \"1019.98\",
  \"currency\": \"USD\"
}

Extract from this OCR text:
" . $text . "

JSON response:";
    }

    private function cleanExtractedText(string $text): string
    {
        // Remove excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Fix common OCR errors
        $corrections = [
            '/\$\s+/' => '$',
            '/(\d)\s+\./' => '$1.',
            '/\.\s+(\d)/' => '.$1',
            '/§/' => '$', // Common OCR error
            '/LL:/' => 'LBP:', // Lebanese Pound
            '/\b0\b/' => 'O', // Common OCR confusion
            '/\bl\b/' => 'I', // Common OCR confusion
        ];

        foreach ($corrections as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }

        return trim($text);
    }

    private function parseAIResponse(string $response): ?array
    {
        // Remove any markdown formatting
        $response = preg_replace('/```json\s*/', '', $response);
        $response = preg_replace('/```\s*$/', '', $response);
        $response = trim($response);

        // Find JSON in response
        if (preg_match('/\{.*\}/s', $response, $matches)) {
            $jsonStr = $matches[0];
        } else {
            $jsonStr = $response;
        }

        $data = json_decode($jsonStr, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $this->validateAndCleanData($data);
        }

        Log::error('Failed to parse AI response: ' . $response);
        Log::error('JSON Error: ' . json_last_error_msg());
        return null;
    }

    private function validateAndCleanData(array $data): array
    {
        $cleaned = [
            'date' => $this->validateDate($data['date'] ?? null),
            'store_name' => $this->cleanString($data['store_name'] ?? null),
            'products' => $this->validateProducts($data['products'] ?? []),
            'total_amount' => $this->validatePrice($data['total_amount'] ?? null),
            'currency' => $data['currency'] ?? 'USD'
        ];

        return $cleaned;
    }

    private function validateDate(?string $date): ?string
    {
        if (!$date) return null;

        // Try to parse different date formats
        $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d', 'd-m-Y'];

        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat($format, $date);
            if ($parsed && $parsed->format($format) === $date) {
                return $parsed->format('Y-m-d');
            }
        }

        return null;
    }

    private function cleanString(?string $str): ?string
    {
        if (!$str) return null;
        return trim(preg_replace('/\s+/', ' ', $str));
    }

    private function validateProducts(array $products): array
    {
        $validated = [];

        foreach ($products as $product) {
            if (isset($product['name']) && isset($product['price'])) {
                $validated[] = [
                    'name' => $this->cleanString($product['name']),
                    'price' => $this->validatePrice($product['price'])
                ];
            }
        }

        return $validated;
    }

    private function validatePrice($price): ?string
    {
        if (!$price) return null;

        // Handle Lebanese Pound and comma separators
        $price = str_replace(',', '', $price); // Remove commas
        $price = preg_replace('/[^\d.]/', '', $price); // Remove non-numeric except dots

        if (is_numeric($price)) {
            return number_format((float)$price, 2, '.', '');
        }

        return null;
    }
}
