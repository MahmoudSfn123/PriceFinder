<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\InvoiceAIService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceProcessorController extends Controller
{
    private $invoiceAIService;

    public function __construct(InvoiceAIService $invoiceAIService)
    {
        $this->invoiceAIService = $invoiceAIService;
    }

    /**
     * Process invoice text using AI to extract structured information
     */
    public function processInvoice(Request $request): JsonResponse
    {
        try {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'extracted_text' => 'required|string|max:50000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400);
            }

            $extractedText = $request->input('extracted_text');

            // Clean and prepare text for AI processing
            $cleanedText = $this->cleanExtractedText($extractedText);

            // Process with AI service
            $parsedData = $this->invoiceAIService->processInvoiceText($cleanedText);

            if ($parsedData) {
                return response()->json([
                    'success' => true,
                    'data' => $parsedData,
                    'message' => 'Invoice processed successfully'
                ]);
            } else {
                throw new \Exception('Failed to extract structured data from invoice');
            }

        } catch (\Exception $e) {
            Log::error('Invoice processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input_length' => strlen($request->input('extracted_text', ''))
            ]);

            \Log::info('Invoice processing response', ['data' => $data]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean and normalize extracted text for better AI processing
     */
    private function cleanExtractedText(string $text): string
    {
        // Remove excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Fix common OCR errors
        $corrections = [
            '/\$\s+/' => '$',                    // Fix spaced dollar signs
            '/(\d)\s+\./' => '$1.',              // Fix decimal points
            '/\.\s+(\d)/' => '.$1',              // Fix decimal points
            '/(\d)\s+,/' => '$1,',               // Fix thousands separators
            '/,\s+(\d)/' => ',$1',               // Fix thousands separators
            '/\b0(?=\d)/' => 'O',                // Common OCR confusion (0 vs O)
            '/\bl(?=\d)/' => '1',                // Common OCR confusion (l vs 1)
            '/\bI(?=\d)/' => '1',                // Common OCR confusion (I vs 1)
        ];

        foreach ($corrections as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }

        return trim($text);
    }
}






