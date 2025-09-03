# 🧾 PriceFinder

**PriceFinder** is a comprehensive web application built with **Laravel PHP** and **Blade templates** that allows users to find the cheapest prices for various items. The platform enables users to upload item prices along with verification documents, such as invoices or receipts, and compare prices across different stores. The project leverages OCR, AI, and modern web technologies to provide an intuitive and efficient price comparison experience.

---

## 🎯 Objective

The aim of this project is to develop a **website** (with potential mobile app extension) that empowers users to:

- Upload and verify item prices with invoices or receipts.
- Browse and compare prices across different stores.
- Make informed purchasing decisions by finding the best deals.

---

## 💡 Key Features

1. **User Registration and Authentication**  
   - Secure account creation and login.
   - Only registered users can upload prices and interact with the platform.

2. **Price Uploading**  
   - Users can submit photos of invoices to upload item prices.
   - Includes item details, store information, and purchase date.

3. **Price Verification**  
   - Automatically verifies invoices using **Tesseract.js** for OCR and validation algorithms.
   - Verified prices are stored in the database for other users to view.

4. **Price Comparison**  
   - Users can search for specific items and see a list of prices submitted by others.
   - Displays best prices along with store and date information.

5. **User Reviews and Ratings**  
   - Users can leave reviews and ratings for products and stores.
   - Ensures reliability and quality of price data.

6. **Invoice Data Extraction**  
   - **Tesseract.js** extracts text from invoice images.
   - **Ollama AI** interprets and analyzes the extracted data.
   - **PrismPHP** highlights and formats extracted content for readability.

7. **Community Engagement**  
   - Users can share shopping tips, deals, and experiences via a forum or discussion board.

---

## 🔧 Technology Stack

| Layer | Technology |
|-------|------------|
| **Frontend** | HTML, CSS, JavaScript, Blade Templates |
| **Backend** | PHP Laravel |
| **Database** | MySQL |
| **OCR** | Tesseract.js |
| **AI Analysis** | Ollama |
| **Syntax Highlighting** | PrismPHP |
| **Optional Mobile App** | Flutter or Xamarin (future extension) |

---

## 📂 Project Structure Overview

app/ # Laravel backend logic

bootstrap/

config/

database/

public/ # CSS, JS, and Blade assets

resources/ # Blade templates, views, and frontend assets

routes/ # Web and API routes

storage/ # File storage (ignored in Git)

tests/

.env.example

.gitignore

composer.json


---

## 🚀 How It Works

1. **Upload Invoice**  
   Users upload images of invoices or receipts.

2. **Text Extraction**  
   **Tesseract.js** scans the invoice image and extracts the text.

3. **AI Data Interpretation**  
   **Ollama AI** analyzes the extracted text and identifies:
   - Item names
   - Prices
   - Purchase dates
   - Store names

4. **Data Formatting**  
   **PrismPHP** highlights and formats the extracted information for readability.

5. **Price Comparison**  
   Users can browse and compare prices across stores to find the best deals.

---

## 🛠 Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/MahmoudSfn123/pricefinder.git
cd pricefinder

Install PHP dependencies:
composer install

Install Node dependencies (if required):
npm install
npm run dev

Configure environment variables:
cp .env.example .env
php artisan key:generate

Run database migrations:
php artisan migrate

Serve the application locally:
php artisan serve

##############################################

🔐 Security Notes

.env contains sensitive configuration and is excluded from Git.

Large folders like /vendor and /node_modules are ignored and installed locally.

Uploaded files are validated to prevent security risks.

📈 Expected Outcomes

Fully functional web application for price comparison.

Verified prices contributed by the user community.

Users can make informed shopping decisions.

Scalable structure for future mobile app integration.

👨‍💻 Author

Mahmoud Saifan
Graduate in Computer and Communication Network Engineering – Lebanese University
Continuing software engineering studies at CNAM
Contact: www.linkedin.com/in/mahmoud-saifan
 | Mahmoud.Saifan@hotmail.com

