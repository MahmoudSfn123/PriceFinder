// document.getElementById("file-upload").addEventListener("change", function(event) {
//     const file = event.target.files[0];
//     if (!file) return;

//     alert("Extracting text from image...");

//     Tesseract.recognize(file, 'eng+ara', {
//         logger: m => console.log(m)
//     }).then(function(result) {
//         const text = result.data.text;
//         console.log("OCR Result:", text);
//         document.getElementById('ocr-result').value = text;
//         alert("Detected text:\n" + text);
//     }).catch(function(error) {
//         console.error("OCR Error:", error);
//         if(error.stack) console.error(error.stack);
//         alert("Error reading text from image:\n" + (error.message || error));
//     });
// });




























///ollama
document.getElementById("file-upload").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (!file) return;

    showLoadingState("Extracting text from image...");

    Tesseract.recognize(file, 'eng+ara', {
        logger: m => {
            if (m.status === 'recognizing text') {
                updateLoadingProgress(m.progress);
            }
        }
    }).then(function(result) {
        const extractedText = result.data.text;
        console.log("OCR Result:", extractedText);

        showLoadingState("Processing invoice data with AI...");
        processInvoiceWithLlama3(extractedText);
    }).catch(function(error) {
        console.error("OCR Error:", error);
        hideLoadingState();
        showError("Error reading text from image: " + (error.message || error));
    });
});

async function processInvoiceWithLlama3(extractedText) {
    try {
        const response = await fetch('/api/process-invoice', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ extracted_text: extractedText })
        });

        if (!response.ok) {
            throw new Error('Failed to process invoice');
        }

        const result = await response.json();

        if (result.success) {
            hideLoadingState();
            populateFormWithExtractedData(result.data);
            showProductsTable(result.data.products);
        } else {
            throw new Error(result.message || 'Failed to extract invoice data');
        }

    } catch (error) {
        console.error('Llama3 Processing Error:', error);
        hideLoadingState();
        showError('Error processing invoice: ' + error.message);
    }
}

function populateFormWithExtractedData(data) {
    if (data.date) {
        document.getElementById('purchase_date').value = data.date;
    }

    if (data.store_name) {
        document.querySelector('input[name="store_name"]').value = data.store_name;
    }

    if (data.products && data.products.length === 1) {
        const product = data.products[0];
        document.getElementById('price').value = product.price;
        fillProductName(product.name);
    }
}

function showProductsTable(products) {
    if (!products || products.length === 0) return;

    const tableBody = document.getElementById('product-table-body');
    const productTable = document.getElementById('product-table');
    tableBody.innerHTML = '';

    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="p-2 border">${product.name}</td>
            <td class="p-2 border">${product.price}</td>
            <td class="p-2 border text-center">
                <button type="button" class="btn btn-sm btn-primary" onclick="selectProduct(${index}, '${product.name}', '${product.price}')">
                    Select
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    productTable.style.display = 'block';
}

function selectProduct(index, name, price) {
    document.getElementById('price').value = price;
    fillProductName(name);
    document.getElementById('product-table').style.display = 'none';
}

function setupProductSelect() {
    const productSelect = document.getElementById("product-select");
    const newProductGroup = document.getElementById("new-product-name-group");
    const newProductInput = document.getElementById("name");

    if (productSelect && newProductGroup) {
        productSelect.addEventListener("change", (e) => {
            if (e.target.value === "add_new") {
                newProductGroup.style.display = "block";
                newProductInput.required = true;
            } else {
                newProductGroup.style.display = "none";
                newProductInput.required = false;
                newProductInput.value = "";
            }
        });
    }
}

function fillProductName(productName) {
    const productSelect = document.getElementById("product-select");
    const newProductGroup = document.getElementById("new-product-name-group");
    const newProductInput = document.getElementById("name");

    if (!productSelect) return;

    const options = Array.from(productSelect.options);
    const existing = options.find(
        option =>
            option.value.toLowerCase().trim() === productName.toLowerCase().trim() ||
            option.text.toLowerCase().includes(productName.toLowerCase())
    );

    if (existing && existing.value !== "add_new") {
        productSelect.value = existing.value;
        newProductGroup.style.display = "none";
        newProductInput.required = false;
        newProductInput.value = "";
    } else {
        productSelect.value = "add_new";
        newProductGroup.style.display = "block";
        newProductInput.required = true;
        newProductInput.value = cleanProductName(productName);
        highlightField(newProductInput);
    }

    highlightField(productSelect);
}

function cleanProductName(name) {
    return name.replace(/[^a-zA-Z0-9\s\-]/g, "").trim();
}

function highlightField(field) {
    if (!field) return;
    field.classList.add("highlighted");
    setTimeout(() => field.classList.remove("highlighted"), 1500);
}

function showLoadingState(message) {
    let overlay = document.getElementById('loading-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'loading-overlay';
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="spinner"></div>
                <p id="loading-message">${message}</p>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
    } else {
        document.getElementById('loading-message').textContent = message;
    }

    overlay.style.display = 'flex';
}

function updateLoadingProgress(progress) {
    const progressFill = document.getElementById('progress-fill');
    if (progressFill) {
        progressFill.style.width = (progress * 100) + '%';
    }
}

function hideLoadingState() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function showError(message) {
    alert(message);
}

// Call setup on page load
document.addEventListener("DOMContentLoaded", function () {
    setupProductSelect();
});

// Add minimal CSS for loader
const style = document.createElement('style');
style.textContent = `
    #loading-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        min-width: 300px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #F28123;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #f3f3f3;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: #F28123;
        width: 0%;
        transition: width 0.3s ease;
    }

    .highlighted {
        border: 2px solid #F28123 !important;
    }
`;
document.head.appendChild(style);















// document.getElementById("file-upload").addEventListener("change", function(event) {
//     const file = event.target.files[0];
//     if (!file) return;

//     // Create loading indicator
//     const loadingDiv = createLoadingIndicator();

//     // Validate file
//     if (!validateFile(file)) {
//         removeLoadingIndicator(loadingDiv);
//         return;
//     }

//     console.log("Starting OCR processing...");
//     updateLoadingMessage(loadingDiv, "📸 Processing image...", 0);

//     Tesseract.recognize(file, 'eng+ara', {
//         logger: m => {
//             console.log('OCR Progress:', m);

//             if (m.status === 'recognizing text') {
//                 const progress = Math.round(m.progress * 100);
//                 updateLoadingMessage(loadingDiv, `🔍 Extracting text... ${progress}%`, progress);
//             } else if (m.status) {
//                 updateLoadingMessage(loadingDiv, `📄 ${m.status}...`, null);
//             }
//         }
//     }).then(function(result) {
//         const text = result.data.text;
//         console.log("OCR Result:", text);

//         // Update loading message
//         updateLoadingMessage(loadingDiv, "✅ Text extracted! Starting AI analysis...", 100);

//         // Set the OCR result
//         const ocrTextarea = document.getElementById('ocr-result');
//         if (ocrTextarea) {
//             ocrTextarea.value = text;
//             ocrTextarea.style.display = 'block';

//             // Trigger AI analysis
//             setTimeout(() => {
//                 if (window.runNER) {
//                     console.log("Triggering AI analysis...");
//                     window.runNER(text).then(() => {
//                         removeLoadingIndicator(loadingDiv);
//                         console.log("AI analysis completed");
//                     }).catch(error => {
//                         console.error("AI analysis failed:", error);
//                         removeLoadingIndicator(loadingDiv);
//                         showError("AI analysis failed. Please check the extracted text and fill the form manually.");
//                     });
//                 } else {
//                     // Fallback: trigger change event
//                     ocrTextarea.dispatchEvent(new Event('change'));
//                     removeLoadingIndicator(loadingDiv);
//                 }
//             }, 500);
//         }

//     }).catch(function(error) {
//         console.error("OCR Error:", error);
//         removeLoadingIndicator(loadingDiv);
//         showError("Failed to extract text from image: " + (error.message || error));
//     });
// });

// function validateFile(file) {
//     const maxSize = 5 * 1024 * 1024; // 5MB
//     const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

//     if (file.size > maxSize) {
//         showError("File size too large. Please use an image smaller than 5MB.");
//         return false;
//     }

//     if (!allowedTypes.includes(file.type)) {
//         showError("Invalid file type. Please use JPG, JPEG, or PNG images.");
//         return false;
//     }

//     return true;
// }

// function createLoadingIndicator() {
//     const loadingDiv = document.createElement('div');
//     loadingDiv.id = 'ocr-loading';
//     loadingDiv.style.cssText = `
//         padding: 15px;
//         margin: 10px 0;
//         background: #f8f9fa;
//         border: 1px solid #dee2e6;
//         border-radius: 4px;
//         text-align: center;
//         font-weight: 500;
//     `;

//     const uploadArea = document.getElementById('upload-area-invoice');
//     uploadArea.parentNode.insertBefore(loadingDiv, uploadArea.nextSibling);

//     return loadingDiv;
// }

// function updateLoadingMessage(loadingDiv, message, progress) {
//     if (!loadingDiv) return;

//     let html = `<div style="margin-bottom: 10px;">${message}</div>`;

//     if (progress !== null) {
//         html += `
//             <div style="width: 100%; background: #e9ecef; border-radius: 4px; height: 8px; overflow: hidden;">
//                 <div style="width: ${progress}%; height: 100%; background: #007bff; transition: width 0.3s ease;"></div>
//             </div>
//         `;
//     }

//     loadingDiv.innerHTML = html;
// }

// function removeLoadingIndicator(loadingDiv) {
//     if (loadingDiv && loadingDiv.parentNode) {
//         loadingDiv.parentNode.removeChild(loadingDiv);
//     }
// }

// function showError(message) {
//     const errorDiv = document.createElement('div');
//     errorDiv.style.cssText = `
//         padding: 12px;
//         margin: 10px 0;
//         background: #f8d7da;
//         border: 1px solid #f5c6cb;
//         color: #721c24;
//         border-radius: 4px;
//         font-weight: 500;
//     `;
//     errorDiv.textContent = message;

//     const uploadArea = document.getElementById('upload-area-invoice');
//     uploadArea.parentNode.insertBefore(errorDiv, uploadArea.nextSibling);

//     // Auto-remove after 5 seconds
//     setTimeout(() => {
//         if (errorDiv.parentNode) {
//             errorDiv.parentNode.removeChild(errorDiv);
//         }
//     }, 5000);
// }

// // Handle product selection dropdown
// document.addEventListener('DOMContentLoaded', function() {
//     const productSelect = document.querySelector('select[name="product_select"]');
//     const newProductGroup = document.getElementById('new-product-name-group');

//     if (productSelect && newProductGroup) {
//         productSelect.addEventListener('change', function() {
//             if (this.value === 'add_new') {
//                 newProductGroup.style.display = 'block';
//                 const newProductField = document.querySelector('input[name="name"]');
//                 if (newProductField) {
//                     newProductField.focus();
//                 }
//             } else {
//                 newProductGroup.style.display = 'none';
//             }
//         });
//     }
// });


































// OCR Invoice Extractor for Laravel Product Form
// OCR Invoice Extractor for Laravel Product Form
// class InvoiceExtractor {
//     constructor() {
//         this.currentFile = null; // Store the current file
//         this.patterns = {
//             // ... your existing regex patterns
//             date: [
//                 /(?:date|invoice date|bill date)[\s:]*(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4})/i,
//                 /(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4})/g,
//                 /(?:date|invoice date)[\s:]*(\d{1,2}\s+(?:jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)[a-z]*\s+\d{2,4})/i,
//                 /\b(?:jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)[a-z]*\s+\d{1,2},?\s*\d{4}\b/i,
//             ],
//             price: [
//                 /(?:price|amount|total|cost)[\s:$]*(\d+(?:\.\d{2})?)/gi,
//                 /^([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,50})\s+(\d+(?:\.\d{2})?)\s+\d+\s+\d+$/gm,
//                 /\$(\d+(?:,\d{3})*(?:\.\d{2})?)/g,
//                 /(\d+(?:\.\d{2})?)[\s]*(?:usd|dollar|\$)/gi,
//             ],
//             storeName: [/^([A-Z][A-Za-z\s&\.]{2,30})$/m, /^([^\d\n]{3,40})$/m],
//             product: [
//                 /^([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,50})\s+(\d+(?:\.\d{2})?)$/gm,
//                 /(\d+)\s+([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,50})\s+(\d+(?:\.\d{2})?)$/gm,
//                 /([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,50})\s+\$?(\d+(?:\.\d{2})?)$/gm,
//             ],
//         };

//         this.init();
//     }

//     init() {
//         // Hide the new product input group by default
//         const newProductGroup = document.getElementById("new-product-name-group");
//         if (newProductGroup) {
//             newProductGroup.style.display = "none";
//         }
//         this.setupFileUpload();
//         this.setupProductSelect();
//         this.setupFormSubmission(); // Add form submission handler
//     }

//     setupFileUpload() {
//         const fileInput = document.getElementById("file-upload");
//         const uploadArea = document.getElementById("upload-area-invoice");
//         const filePreview = document.getElementById("file-preview-invoice");
//         const removeButton = document.getElementById("remove-file-invoice");
//         const ocrResult = document.getElementById("ocr-result");

//         if (!fileInput || !uploadArea) return;

//         // Handle file selection
//         fileInput.addEventListener("change", (e) => {
//             const file = e.target.files[0];
//             if (file) {
//                 this.currentFile = file; // Store the file
//                 this.handleFileUpload(file);
//             }
//         });

//         // Handle drag and drop
//         uploadArea.addEventListener("dragover", (e) => {
//             e.preventDefault();
//             uploadArea.classList.add("drag-over");
//         });

//         uploadArea.addEventListener("dragleave", (e) => {
//             e.preventDefault();
//             uploadArea.classList.remove("drag-over");
//         });

//         uploadArea.addEventListener("drop", (e) => {
//             e.preventDefault();
//             uploadArea.classList.remove("drag-over");
//             const file = e.dataTransfer.files[0];
//             if (file && file.type.startsWith("image/")) {
//                 this.currentFile = file; // Store the file
//                 // Create a new FileList with the dropped file
//                 const dt = new DataTransfer();
//                 dt.items.add(file);
//                 fileInput.files = dt.files;
//                 this.handleFileUpload(file);
//             }
//         });

//         // Remove file
//         if (removeButton) {
//             removeButton.addEventListener("click", () => {
//                 this.removeFile();
//             });
//         }
//     }

//     async uploadInvoiceTemp(file) {
//     const formData = new FormData();
//     formData.append("invoice", file);

//     try {
//         const response = await fetch("/invoices/temp-upload", {
//             method: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
//             },
//             body: formData
//         });

//         const result = await response.json();

//         if (result.status === "success") {
//             console.log("Temp invoice uploaded:", result.path);
//             const invoicePathInput = document.getElementById("invoice_path");
//             if (invoicePathInput) {
//                 invoicePathInput.value = result.path;
//             }
//         } else {
//             this.showNotification("Invoice upload failed", "error");
//         }
//     } catch (error) {
//         console.error("Temp upload failed:", error);
//         this.showNotification("Upload error. Check console for details.", "error");
//     }
// }


//     // NEW: Add form submission handler to ensure file persistence
//     setupFormSubmission() {
//         const form = document.getElementById("product-form");
//         if (form) {
//             form.addEventListener("submit", (e) => {
//                 // Ensure the file is still in the input before submission
//                 if (this.currentFile) {
//                     const fileInput = document.getElementById("file-upload");
//                     if (fileInput && (!fileInput.files || fileInput.files.length === 0)) {
//                         // Re-attach the file if it's missing
//                         const dt = new DataTransfer();
//                         dt.items.add(this.currentFile);
//                         fileInput.files = dt.files;
//                         console.log("File re-attached before submission:", this.currentFile.name);
//                     }
//                 }
//             });
//         }
//     }

//     convertToISODate(mmddyyyy) {
//         const parts = mmddyyyy.split("/");
//         if (parts.length !== 3) return ""; // invalid format

//         const [month, day, year] = parts;

//         // Pad month and day if needed
//         const mm = month.padStart(2, "0");
//         const dd = day.padStart(2, "0");

//         return `${year}-${mm}-${dd}`;
//     }

//     setupProductSelect() {
//         const productSelect = document.getElementById("product-select");
//         const newProductGroup = document.getElementById("new-product-name-group");
//         const newProductInput = document.getElementById("name");

//         if (productSelect && newProductGroup) {
//             productSelect.addEventListener("change", (e) => {
//                 if (e.target.value === "add_new") {
//                     newProductGroup.style.display = "block";
//                     newProductInput.required = true;
//                 } else {
//                     newProductGroup.style.display = "none";
//                     newProductInput.required = false;
//                     newProductInput.value = "";
//                 }
//             });
//         }
//     }

//     async handleFileUpload(file) {
//     try {


//         // Update file preview
//         this.updateFilePreview(file);

//         // Store the file reference
//         this.currentFile = file;

//         // Process with Tesseract OCR
//         const {
//             data: { text },
//         } = await Tesseract.recognize(file, "eng", {
//             logger: (m) => {
//                 if (m.status === "recognizing text") {
//                     console.log(`OCR Progress: ${Math.round(m.progress * 100)}%`);
//                 }
//             },
//         });

//         console.log("OCR Text:", text);

//         // Show OCR result in textarea
//         const ocrTextarea = document.getElementById("ocr-result");
//         if (ocrTextarea) {
//             ocrTextarea.value = text;
//             ocrTextarea.style.display = "block";
//         }

//         // Extract information and fill form
//         const extractedData = this.extractInvoiceInfo(text);
//         this.fillForm(extractedData);

//         // ✅ Upload invoice to server temporarily
//         await this.uploadInvoiceTemp(file);

//         // Re-attach the file after OCR processing
//         this.attachFileToInput();

//         // Success message
//         this.showNotification("Invoice processed successfully!", "success");
//     } catch (error) {
//         console.error("OCR Error:", error);
//         this.showNotification("Error processing invoice. Please try again.", "error");
//     } finally {
//         this.showLoadingState(false);
//     }
// }


//     // NEW: Method to ensure file is attached to input
//     attachFileToInput() {
//         if (this.currentFile) {
//             const fileInput = document.getElementById("file-upload");
//             if (fileInput) {
//                 const dt = new DataTransfer();
//                 dt.items.add(this.currentFile);
//                 fileInput.files = dt.files;
//                 console.log("File attached to input:", this.currentFile.name);
//             }
//         }
//     }

//     extractInvoiceInfo(text) {
//         const lines = text.split("\n").filter((line) => line.trim().length > 0);

//         const result = {
//             storeName: this.extractStoreName(lines),
//             products: this.extractProductList(lines),
//             price: this.extractPrice(text),
//             purchaseDate: this.extractDate(text),
//             rawText: text,
//         };

//         console.log("Extracted Data:", result);
//         return result;
//     }

//     extractStoreName(lines) {
//         // Store name is usually in the first few lines
//         for (let i = 0; i < Math.min(5, lines.length); i++) {
//             const line = lines[i].trim();

//             if (this.isLikelyStoreName(line)) {
//                 return this.cleanStoreName(line);
//             }
//         }

//         // Fallback to first meaningful line
//         const firstLine = lines.find(
//             (line) =>
//                 line.trim().length > 3 &&
//                 !line.match(/^\d+$/) &&
//                 !line.toLowerCase().includes("receipt")
//         );

//         return firstLine ? this.cleanStoreName(firstLine.trim()) : "";
//     }

//     isLikelyStoreName(line) {
//         const excludeWords = [
//             "receipt",
//             "invoice",
//             "bill",
//             "date",
//             "time",
//             "total",
//             "tax",
//             "subtotal",
//             "qty",
//             "price",
//             "amount",
//             "customer",
//             "order",
//         ];

//         const lowerLine = line.toLowerCase();
//         const hasExcludedWord = excludeWords.some((word) => lowerLine.includes(word));
//         const isReasonableLength = line.length >= 3 && line.length <= 50;
//         const hasLetters = /[a-zA-Z]{2,}/.test(line);
//         const notJustNumbers = !/^\d+[\.\-\/]*\d*$/.test(line.trim());

//         return !hasExcludedWord && isReasonableLength && hasLetters && notJustNumbers;
//     }

//     cleanStoreName(name) {
//         // Clean up store name
//         return name
//             .replace(/[^\w\s&\.-]/g, "")
//             .replace(/\s+/g, " ")
//             .trim()
//             .split(" ")
//             .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
//             .join(" ");
//     }

//     extractProductList(lines) {
//         const products = [];

//         for (const line of lines) {
//             if (this.isHeaderOrTotal(line)) continue;

//             const match = this.findProductInLine(line);
//             if (match) {
//                 products.push({
//                     name: match.name,
//                     price: match.price,
//                 });
//             }
//         }

//         return products;
//     }

//     isHeaderOrTotal(line) {
//         const lowerLine = line.toLowerCase();
//         const excludePatterns = [
//             "total",
//             "subtotal",
//             "tax",
//             "qty",
//             "quantity",
//             "price",
//             "amount",
//             "receipt",
//             "invoice",
//             "date",
//             "time",
//             "cashier",
//             "store",
//             "thank you",
//         ];

//         return excludePatterns.some((pattern) => lowerLine.includes(pattern));
//     }

//     findProductInLine(line) {
//         // Pattern 1: Product name followed by price
//         let match = line.match(/^([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,40})\s+\$?(\d+(?:\.\d{2})?)$/);
//         if (match) {
//             return {
//                 name: match[1].trim(),
//                 price: parseFloat(match[2]),
//             };
//         }

//         // Pattern 2: Quantity + Product name + Price
//         match = line.match(/^\d+\s+([a-zA-Z][a-zA-Z0-9\s\-&\.]{2,40})\s+\$?(\d+(?:\.\d{2})?)$/);
//         if (match) {
//             return {
//                 name: match[1].trim(),
//                 price: parseFloat(match[2]),
//             };
//         }

//         return null;
//     }

//     extractPrice(text) {
//         let pricesInUSD = [];
//         let pricesInLL = [];

//         for (const pattern of this.patterns.price) {
//             const matches = [...text.matchAll(pattern)];
//             if (matches.length > 0) {
//                 for (const match of matches) {
//                     const raw = match[1].replace(/,/g, "");
//                     const value = parseFloat(raw);
//                     if (!isNaN(value)) {
//                         const isLL = match[0].toLowerCase().includes("ll") || value > 10000;
//                         if (isLL) {
//                             pricesInLL.push(value);
//                         } else {
//                             pricesInUSD.push(value);
//                         }
//                     }
//                 }
//             }
//         }

//         // Prefer USD if available, else convert max LL to USD
//         if (pricesInUSD.length > 0) {
//             return Math.max(...pricesInUSD);
//         } else if (pricesInLL.length > 0) {
//             const maxLL = Math.max(...pricesInLL);
//             return parseFloat((maxLL / 90000).toFixed(2));
//         }

//         return "";
//     }

//     extractDate(text) {
//         for (const pattern of this.patterns.date) {
//             const match = text.match(pattern);
//             if (match) {
//                 return this.formatDate(match[1] || match[0]);
//             }
//         }
//         return "";
//     }

//     formatDate(dateStr) {
//         try {
//             // Handle different date formats and convert to YYYY-MM-DD
//             let date;

//             if (dateStr.includes("/") || dateStr.includes("-") || dateStr.includes(".")) {
//                 const parts = dateStr.split(/[\/\-\.]/);
//                 if (parts.length === 3) {
//                     // Try different combinations
//                     const year =
//                         parts.find((p) => p.length === 4) ||
//                         (parts[2].length === 2 ? "20" + parts[2] : parts[2]);
//                     const month = parts[0].length <= 2 ? parts[0] : parts[1];
//                     const day = parts[0].length <= 2 ? parts[1] : parts[0];

//                     date = new Date(year, month - 1, day);
//                 }
//             } else {
//                 date = new Date(dateStr);
//             }

//             if (date && !isNaN(date.getTime())) {
//                 const mm = String(date.getMonth() + 1).padStart(2, "0");
//                 const dd = String(date.getDate()).padStart(2, "0");
//                 const yyyy = date.getFullYear();
//                 return `${mm}/${dd}/${yyyy}`;
//             }
//         } catch (e) {
//             console.error("Date parsing error:", e);
//         }
//         return "";
//     }

//     fillForm(extractedData) {
//         // Fill store name
//         if (extractedData.storeName) {
//             const storeField = document.querySelector('input[name="store_name"]');
//             if (storeField) {
//                 storeField.value = extractedData.storeName;
//                 this.highlightField(storeField);
//             }
//         }

//         // Show selectable product table
//         if (extractedData.products && extractedData.products.length > 0) {
//             this.renderProductTable(extractedData.products);
//         }

//         // Fill purchase date
//         if (extractedData.purchaseDate) {
//             const dateField = document.getElementById("purchase_date");
//             if (dateField) {
//                 const isoDate = this.convertToISODate(extractedData.purchaseDate);
//                 dateField.value = isoDate; // Fill with ISO format
//                 this.highlightField(dateField);
//             }
//         }

//         // Show extraction summary
//         this.showExtractionSummary(extractedData);
//     }

//     fillProductName(productName) {
//         const productSelect = document.getElementById("product-select");
//         const newProductGroup = document.getElementById("new-product-name-group");
//         const newProductInput = document.getElementById("name");

//         if (!productSelect) return;

//         // Check if product exists in options
//         const options = Array.from(productSelect.options);
//         const existing = options.find(
//             (option) =>
//                 option.value.toLowerCase() === productName.toLowerCase() ||
//                 option.text.toLowerCase().includes(productName.toLowerCase())
//         );

//         if (existing && existing.value !== "add_new") {
//             productSelect.value = existing.value;
//             if (newProductGroup) newProductGroup.style.display = "none";
//             if (newProductInput) newProductInput.required = false;
//         } else {
//             productSelect.value = "add_new";
//             if (newProductGroup) newProductGroup.style.display = "block";
//             if (newProductInput) {
//                 newProductInput.required = true;
//                 newProductInput.value = this.cleanProductName(productName);
//                 this.highlightField(newProductInput);
//             }
//         }

//         this.highlightField(productSelect);
//     }

//     renderProductTable(products) {
//         const tableContainer = document.getElementById("product-table");
//         const tbody = document.getElementById("product-table-body");

//         if (!tableContainer || !tbody) return;

//         tbody.innerHTML = ""; // clear previous
//         tableContainer.style.display = "block";

//         products.forEach((product, index) => {
//             const row = document.createElement("tr");

//             // Convert LL to USD if necessary
//             const rawPrice = product.price;
//             const isLL = rawPrice > 10000;
//             const convertedPrice = isLL ? parseFloat((rawPrice / 90000).toFixed(2)) : rawPrice;

//             row.innerHTML = `
//                 <td class="p-2 border">${product.name}</td>
//                 <td class="p-2 border">${
//                     isLL ? `${rawPrice} LL ≈ $${convertedPrice}` : `$${convertedPrice}`
//                 }</td>
//                 <td class="p-2 border text-center">
//                     <button class="select-product-button bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded" data-index="${index}" data-price="${convertedPrice}">
//                         Select
//                     </button>
//                 </td>
//             `;

//             tbody.appendChild(row);
//         });

//         // Add click events
//         tbody.querySelectorAll(".select-product-button").forEach((button) => {
//             button.addEventListener("click", () => {
//                 const index = parseInt(button.getAttribute("data-index"));
//                 const selected = products[index];

//                 // Convert if needed
//                 const isLL = selected.price > 10000;
//                 const convertedPrice = isLL
//                     ? parseFloat((selected.price / 90000).toFixed(2))
//                     : selected.price;

//                 // Fill product name
//                 this.fillProductName(selected.name);

//                 // Fill converted price
//                 const priceField = document.getElementById("price");
//                 if (priceField) {
//                     priceField.value = convertedPrice.toFixed(2);
//                     this.highlightField(priceField);
//                 }

//                 this.highlightField(document.getElementById("product-select"));
//                 this.showNotification(`Product "${selected.name}" selected.`, "success");
//             });
//         });
//     }

//     cleanProductName(name) {
//         return name
//             .replace(/[^\w\s\-&\.]/g, "")
//             .replace(/\s+/g, " ")
//             .trim()
//             .split(" ")
//             .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
//             .join(" ");
//     }

//     highlightField(field) {
//         // Add visual feedback for auto-filled fields
//         field.style.borderColor = "#10B981";
//         field.style.borderWidth = "2px";
//         field.style.backgroundColor = "#F0FDF4";

//         // Remove highlight after 3 seconds
//         setTimeout(() => {
//             field.style.borderColor = "";
//             field.style.borderWidth = "";
//             field.style.backgroundColor = "";
//         }, 3000);
//     }

//     updateFilePreview(file) {
//         const uploadArea = document.getElementById("upload-area-invoice");
//         const filePreview = document.getElementById("file-preview-invoice");
//         const fileName = filePreview.querySelector(".file-name");
//         const fileSize = filePreview.querySelector(".file-size");

//         if (uploadArea && filePreview) {
//             uploadArea.style.display = "none";
//             filePreview.classList.remove("hidden");

//             if (fileName) fileName.textContent = file.name;
//             if (fileSize) fileSize.textContent = this.formatFileSize(file.size);
//         }
//     }

//     removeFile() {
//         const fileInput = document.getElementById("file-upload");
//         const uploadArea = document.getElementById("upload-area-invoice");
//         const filePreview = document.getElementById("file-preview-invoice");
//         const ocrResult = document.getElementById("ocr-result");

//         // Clear the current file reference
//         this.currentFile = null;

//         // Clear file input
//         if (fileInput) {
//             fileInput.value = "";
//         }

//         // Show upload area and hide preview
//         if (uploadArea) {
//             uploadArea.style.display = "block";
//         }

//         if (filePreview) {
//             filePreview.classList.add("hidden");
//             // Clear preview texts
//             const fileName = filePreview.querySelector(".file-name");
//             const fileSize = filePreview.querySelector(".file-size");
//             if (fileName) fileName.textContent = "";
//             if (fileSize) fileSize.textContent = "";
//         }

//         if (ocrResult) {
//             ocrResult.style.display = "none";
//             ocrResult.value = "";
//         }

//         // Clear form fields related to invoice extraction
//         const fieldsToClear = ["store_name", "purchase_date", "price", "name", "product-select"];

//         fieldsToClear.forEach((fieldNameOrId) => {
//             let field = document.querySelector(
//                 `input[name="${fieldNameOrId}"], input#${fieldNameOrId}, select#${fieldNameOrId}`
//             );
//             if (field) {
//                 if (field.tagName.toLowerCase() === "select") {
//                     field.value = "";
//                 } else {
//                     field.value = "";
//                 }
//                 field.style.borderColor = "";
//                 field.style.borderWidth = "";
//                 field.style.backgroundColor = "";
//             }
//         });

//         const newProductGroup = document.getElementById("new-product-name-group");
//         if (newProductGroup) {
//             newProductGroup.style.display = "none";
//         }

//         const productTable = document.getElementById("product-table");
//         const tbody = document.getElementById("product-table-body");
//         if (tbody) tbody.innerHTML = "";
//         if (productTable) productTable.style.display = "none";

//         const summaryDiv = document.getElementById("extraction-summary");
//         if (summaryDiv) summaryDiv.remove();
//     }

//     formatFileSize(bytes) {
//         if (bytes === 0) return "0 Bytes";
//         const k = 1024;
//         const sizes = ["Bytes", "KB", "MB", "GB"];
//         const i = Math.floor(Math.log(bytes) / Math.log(k));
//         return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
//     }

//     showLoadingState(show) {
//         const uploadArea = document.getElementById("upload-area-invoice");
//         const loadingText = "Processing invoice...";

//         if (show) {
//             if (uploadArea) {
//                 uploadArea.innerHTML = `
//                     <div class="loading-spinner">
//                         <i class="fa-solid fa-spinner fa-spin icon-large"></i>
//                         <p class="upload-text">${loadingText}</p>
//                     </div>
//                 `;
//             }
//         }
//     }

//     showExtractionSummary(data) {
//         // Create or update extraction summary
//         let summaryDiv = document.getElementById("extraction-summary");
//         if (!summaryDiv) {
//             summaryDiv = document.createElement("div");
//             summaryDiv.id = "extraction-summary";
//             summaryDiv.className = "card";
//             summaryDiv.style.marginBottom = "1.5rem";

//             const form = document.getElementById("product-form");
//             if (form) {
//                 form.insertBefore(summaryDiv, form.firstChild);
//             }
//         }

//         const extractedFields = [];
//         if (data.storeName) extractedFields.push(`Store: ${data.storeName}`);
//         if (data.price) extractedFields.push(`Total Price: $${data.price.toFixed(2)}`);
//         if (data.purchaseDate) extractedFields.push(`Date: ${data.purchaseDate}`);

//         summaryDiv.innerHTML = `
//             <div class="card-header">
//                 <h3 class="card-title">
//                     <i class="fa-solid fa-check-circle" style="color: #F28123;"></i>
//                     Invoice Information Extracted
//                 </h3>
//             </div>
//             <div class="card-content">
//                 <p style="color: #059669; margin-bottom: 1rem;">
//                     The following information was automatically extracted from your invoice:
//                 </p>
//                 <ul style="list-style-type: disc; margin-left: 1.5rem; color: #374151;">
//                     ${extractedFields.map((field) => `<li>${field}</li>`).join("")}
//                 </ul>
//                 <p style="color: #6B7280; font-size: 1rem; margin-top: 1rem;">
//                     Please verify the information and make any necessary corrections before submitting.
//                 </p>
//             </div>
//         `;
//     }

//     showNotification(message, type = "info") {
//         // Create notification element
//         const notification = document.createElement("div");
//         notification.className = `notification notification-${type}`;
//         notification.style.cssText = `
//             position: fixed;
//             top: 20px;
//             left: 50%;
//             transform: translateX(-50%);
//             padding: 1rem 1.5rem;
//             background: ${
//                 type === "success" ? "#10B981" : type === "error" ? "#EF4444" : "#3B82F6"
//             };
//             color: white;
//             border-radius: 0.5rem;
//             box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
//             z-index: 1000;
//             animation: slideIn 0.3s ease-out;
//         `;

//         notification.innerHTML = `
//             <div style="display: flex; align-items: center; gap: 0.5rem;">
//                 <i class="fa-solid fa-${
//                     type === "success" ? "check" : type === "error" ? "times" : "info"
//                 }-circle"></i>
//                 <span>${message}</span>
//             </div>
//         `;

//         document.body.appendChild(notification);

//         // Remove notification after 5 seconds
//         setTimeout(() => {
//             notification.style.animation = "slideOut 0.3s ease-in";
//             setTimeout(() => {
//                 if (notification.parentNode) {
//                     notification.parentNode.removeChild(notification);
//                 }
//             }, 300);
//         }, 5000);
//     }
// }

// // Add CSS for animations
// const style = document.createElement("style");
// style.textContent = `
//     @keyframes slideIn {
//         from {
//             transform: translate(-50%, -100%);
//             opacity: 0;
//         }
//         to {
//             transform: translate(-50%, 0);
//             opacity: 1;
//         }
//     }

//     @keyframes slideOut {
//         from {
//             transform: translate(-50%, 0);
//             opacity: 1;
//         }
//         to {
//             transform: translate(-50%, -100%);
//             opacity: 0;
//         }
//     }

//     .drag-over {
//         border-color: #3B82F6 !important;
//         background-color: #EFF6FF !important;
//     }

//     .loading-spinner {
//         display: flex;
//         flex-direction: column;
//         align-items: center;
//         justify-content: center;
//         padding: 2rem;
//     }

//     .loading-spinner .fa-spinner {
//         font-size: 2rem;
//         color: #3B82F6;
//         margin-bottom: 1rem;
//     }
// `;
// document.head.appendChild(style);

// // Initialize the extractor when DOM is loaded
// document.addEventListener("DOMContentLoaded", () => {
//     window.invoiceExtractor = new InvoiceExtractor();
// });

// // Make it globally available
// window.InvoiceExtractor = InvoiceExtractor;

