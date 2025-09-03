// // Import Transformers.js from CDN
// import { pipeline } from 'https://cdn.jsdelivr.net/npm/@xenova/transformers@2.17.2/dist/transformers.min.js';

// let nerPipeline = null;
// let isAIInitialized = false;

// // Currency conversion constants
// const EXCHANGE_RATES = {
//     LBP_TO_USD: 1 / 90000, // 1$ = 90,000 LL
//     USD_TO_LBP: 90000
// };

// // Show popup notifications to user
// function showPopup(message, type = 'info', duration = 5000) {
//     // Remove any existing popups
//     const existingPopups = document.querySelectorAll('.popup-notification');
//     existingPopups.forEach(popup => popup.remove());

//     // Create popup element
//     const popup = document.createElement('div');
//     popup.className = `popup-notification popup-${type}`;

//     // Get appropriate icon based on type
//     const icons = {
//         info: '🔍',
//         success: '✅',
//         error: '❌',
//         warning: '⚠️',
//         loading: '🔄'
//     };

//     popup.innerHTML = `
//         <div class="popup-content">
//             <span class="popup-icon">${icons[type] || '📢'}</span>
//             <span class="popup-message">${message}</span>
//             <button class="popup-close" onclick="this.parentElement.parentElement.remove()">×</button>
//         </div>
//         ${type === 'loading' ? '<div class="popup-progress"><div class="popup-progress-bar"></div></div>' : ''}
//     `;

//     // Add popup to page
//     document.body.appendChild(popup);

//     // Animate in
//     setTimeout(() => {
//         popup.classList.add('popup-show');
//     }, 10);

//     // Auto-hide after duration (except for loading type)
//     if (type !== 'loading' && duration > 0) {
//         setTimeout(() => {
//             hidePopup(popup);
//         }, duration);
//     }

//     console.log(`[AI Status] ${message}`);
//     return popup;
// }

// function hidePopup(popup) {
//     if (popup && popup.parentElement) {
//         popup.classList.remove('popup-show');
//         popup.classList.add('popup-hide');
//         setTimeout(() => {
//             if (popup.parentElement) {
//                 popup.remove();
//             }
//         }, 300);
//     }
// }

// // Initialize popup styles
// function initializePopupStyles() {
//     const style = document.createElement('style');
//     style.textContent = `
//         .popup-notification {
//             position: fixed;
//             top: 20px;
//             left: 50%;
//             transform: translateX(-50%) translateY(-100px);
//             background: white;
//             border-radius: 12px;
//             box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
//             z-index: 10000;
//             min-width: 300px;
//             max-width: 500px;
//             opacity: 0;
//             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
//             border-left: 4px solid #007bff;
//             overflow: hidden;
//         }

//         .popup-notification.popup-show {
//             opacity: 1;
//             transform: translateX(-50%) translateY(0);
//         }

//         .popup-notification.popup-hide {
//             opacity: 0;
//             transform: translateX(-50%) translateY(-50px);
//         }

//         .popup-notification.popup-success {
//             border-left-color: #28a745;
//         }

//         .popup-notification.popup-error {
//             border-left-color: #dc3545;
//         }

//         .popup-notification.popup-warning {
//             border-left-color: #ffc107;
//         }

//         .popup-notification.popup-loading {
//             border-left-color: #17a2b8;
//         }

//         .popup-content {
//             padding: 16px 20px;
//             display: flex;
//             align-items: center;
//             gap: 12px;
//             font-size: 14px;
//             font-weight: 500;
//             color: #333;
//         }

//         .popup-icon {
//             font-size: 20px;
//             flex-shrink: 0;
//         }

//         .popup-message {
//             flex: 1;
//             line-height: 1.4;
//         }

//         .popup-close {
//             background: none;
//             border: none;
//             font-size: 20px;
//             cursor: pointer;
//             color: #666;
//             padding: 0;
//             width: 24px;
//             height: 24px;
//             display: flex;
//             align-items: center;
//             justify-content: center;
//             border-radius: 50%;
//             transition: all 0.2s ease;
//         }

//         .popup-close:hover {
//             background: rgba(0, 0, 0, 0.1);
//             color: #333;
//         }

//         .popup-progress {
//             height: 3px;
//             background: rgba(0, 0, 0, 0.1);
//             overflow: hidden;
//         }

//         .popup-progress-bar {
//             height: 100%;
//             background: #007bff;
//             animation: popup-loading 1.5s ease-in-out infinite;
//         }

//         .popup-notification.popup-success .popup-progress-bar {
//             background: #28a745;
//         }

//         .popup-notification.popup-error .popup-progress-bar {
//             background: #dc3545;
//         }

//         .popup-notification.popup-warning .popup-progress-bar {
//             background: #ffc107;
//         }

//         .popup-notification.popup-loading .popup-progress-bar {
//             background: #17a2b8;
//         }

//         @keyframes popup-loading {
//             0% { transform: translateX(-100%); }
//             50% { transform: translateX(0%); }
//             100% { transform: translateX(100%); }
//         }

//         /* Hide OCR textarea by default */
//         #ocr-result {
//             display: none !important;
//         }

//         /* Product table styles */
//         .product-table { margin-top: 20px; }
//         .product-row { cursor: pointer; transition: background-color 0.2s; }
//         .product-row:hover { background-color: #f8f9fa; }
//         .product-row.selected { background-color: #e3f2fd; }
//         .select-button {
//             background: #007bff;
//             color: white;
//             border: none;
//             padding: 5px 10px;
//             border-radius: 3px;
//             cursor: pointer;
//         }
//         .select-button:hover { background: #0056b3; }

//         /* Currency conversion styles */
//         .currency-info {
//             background: #f8f9fa;
//             border: 1px solid #e9ecef;
//             border-radius: 4px;
//             padding: 8px;
//             margin-top: 4px;
//             font-size: 12px;
//             color: #6c757d;
//         }

//         .converted-price {
//             color: #28a745;
//             font-weight: bold;
//         }

//         .original-price {
//             color: #6c757d;
//             text-decoration: line-through;
//             font-size: 0.9em;
//         }
//     `;
//     document.head.appendChild(style);
// }

// // Currency detection and conversion functions
// function detectCurrency(text) {
//     // Lebanese Lira patterns
//     const liraPatterns = [
//         /(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:LL|L\.L\.|LBP|ل\.ل)/gi,
//         /(?:LL|L\.L\.|LBP|ل\.ل)\s*(\d+(?:,\d{3})*(?:\.\d{2})?)/gi,
//         /(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:ليرة|لبنانية)/gi
//     ];

//     // USD patterns
//     const usdPatterns = [
//         /\$(\d+(?:,\d{3})*(?:\.\d{2})?)/gi,
//         /(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:USD|usd|\$)/gi,
//         /(?:USD|usd|\$)\s*(\d+(?:,\d{3})*(?:\.\d{2})?)/gi
//     ];

//     const currencies = {
//         LBP: [],
//         USD: []
//     };

//     // Find LBP amounts
//     liraPatterns.forEach(pattern => {
//         let match;
//         while ((match = pattern.exec(text)) !== null) {
//             const amount = parseFloat(match[1].replace(/,/g, ''));
//             if (amount > 0) {
//                 currencies.LBP.push({
//                     amount: amount,
//                     original: match[0],
//                     converted: convertLBPToUSD(amount)
//                 });
//             }
//         }
//     });

//     // Find USD amounts
//     usdPatterns.forEach(pattern => {
//         let match;
//         while ((match = pattern.exec(text)) !== null) {
//             const amount = parseFloat(match[1].replace(/,/g, ''));
//             if (amount > 0) {
//                 currencies.USD.push({
//                     amount: amount,
//                     original: match[0],
//                     converted: amount // Already in USD
//                 });
//             }
//         }
//     });

//     return currencies;
// }

// function convertLBPToUSD(lbpAmount) {
//     return lbpAmount * EXCHANGE_RATES.LBP_TO_USD;
// }

// function convertUSDToLBP(usdAmount) {
//     return usdAmount * EXCHANGE_RATES.USD_TO_LBP;
// }

// function formatCurrency(amount, currency = 'USD') {
//     if (currency === 'USD') {
//         return `$${amount.toFixed(2)}`;
//     } else if (currency === 'LBP') {
//         return `${amount.toLocaleString()} LL`;
//     }
//     return amount.toString();
// }

// // Initialize NER pipeline
// async function initializeNER() {
//     let loadingPopup = null;

//     try {
//         loadingPopup = showPopup("🤖 Initializing AI system...", 'loading', 0);

//         // Try primary model first - using a more reliable model
//         nerPipeline = await pipeline('token-classification', 'Xenova/bert-base-NER', {
//             use_browser_cache: false,
//         });

//         isAIInitialized = true;

//         // Hide loading popup
//         if (loadingPopup) hidePopup(loadingPopup);

//         showPopup("AI system ready!", 'success');

//     } catch (error) {
//         console.error("Primary NER model failed:", error);

//         // Update loading popup
//         if (loadingPopup) {
//             loadingPopup.querySelector('.popup-message').textContent = "Loading fallback AI model...";
//             loadingPopup.className = 'popup-notification popup-warning popup-show';
//         }

//         try {
//             // Fallback to a simpler model
//             nerPipeline = await pipeline('token-classification', 'Xenova/bert-base-NER', {
//                 use_browser_cache: false,
//             });

//             isAIInitialized = true;

//             // Hide loading popup
//             if (loadingPopup) hidePopup(loadingPopup);

//             showPopup("AI system ready (fallback mode)!", 'success');

//         } catch (fallbackError) {
//             console.error("Fallback model failed:", fallbackError);
//             isAIInitialized = false;

//             // Hide loading popup
//             if (loadingPopup) hidePopup(loadingPopup);

//             showPopup("AI system failed to initialize. Manual input required.", 'error');
//         }
//     }
// }

// async function runNER(text) {
//     let processingPopup = null;

//     if (!isAIInitialized) {
//         const initPopup = showPopup("AI system not ready. Initializing...", 'warning');
//         await initializeNER();
//         hidePopup(initPopup);
//     }

//     if (!nerPipeline) {
//         showPopup("AI system unavailable. Please fill form manually.", 'error');
//         return;
//     }

//     try {
//         processingPopup = showPopup("🔍 AI analyzing invoice data...", 'loading', 0);

//         // Run NER
//         const result = await nerPipeline(text);
//         console.log("NER Result:", result);

//         // Process results
//         await processInvoiceData(result, text);

//         // Hide processing popup
//         if (processingPopup) hidePopup(processingPopup);

//     } catch (error) {
//         console.error("NER processing error:", error);

//         // Hide processing popup
//         if (processingPopup) hidePopup(processingPopup);

//         showPopup("AI analysis failed. Please fill form manually.", 'error');
//     }
// }

// async function processInvoiceData(nerResult, originalText) {
//     const processingPopup = showPopup("📊 Processing invoice data...", 'loading', 0);

//     // Extract entities
//     const entities = groupEntities(nerResult);
//     console.log("Extracted entities:", entities);

//     // Detect and convert currencies
//     const currencies = detectCurrency(originalText);
//     console.log("Detected currencies:", currencies);

//     // Extract products and prices with currency conversion
//     const products = extractProductsWithCurrency(originalText, currencies);
//     console.log("Extracted products:", products);

//     // Auto-fill form fields
//     const filledFields = await autoFillForm(entities, originalText);

//     // Show product selection table
//     if (products.length > 0) {
//         showProductTable(products);
//     }

//     // Hide processing popup
//     if (processingPopup) hidePopup(processingPopup);

//     // Show completion status
//     const fieldCount = filledFields.length;
//     const productCount = products.length;
//     const lbpCount = currencies.LBP.length;

//     if (fieldCount > 0 || productCount > 0) {
//         const currencyMsg = lbpCount > 0 ? ` (${lbpCount} LBP prices converted to USD)` : '';
//         showPopup(`Analysis complete! Auto-filled ${fieldCount} field(s), found ${productCount} product(s)${currencyMsg}`, 'success');
//     } else {
//         showPopup("Analysis complete, but no data could be automatically extracted.", 'warning');
//     }
// }

// function groupEntities(result) {
//     const entities = {
//         organizations: [],
//         persons: [],
//         locations: [],
//         dates: [],
//         money: [],
//         misc: []
//     };

//     let currentEntity = null;
//     let currentTokens = [];

//     for (const item of result) {
//         const label = item.entity || item.entity_group;
//         const word = item.word;

//         if (!label || !word) continue;

//         const cleanLabel = label.replace(/^[BI]-/, '');

//         if (label.startsWith('B-') || currentEntity !== cleanLabel) {
//             if (currentEntity && currentTokens.length > 0) {
//                 addEntityToGroup(entities, currentEntity, currentTokens.join(' '));
//             }
//             currentEntity = cleanLabel;
//             currentTokens = [word.replace(/^##/, '')];
//         } else if (label.startsWith('I-') && currentEntity === cleanLabel) {
//             currentTokens.push(word.replace(/^##/, ''));
//         }
//     }

//     if (currentEntity && currentTokens.length > 0) {
//         addEntityToGroup(entities, currentEntity, currentTokens.join(' '));
//     }

//     return entities;
// }

// function addEntityToGroup(entities, entityType, text) {
//     const cleanText = text.replace(/##/g, '').trim();

//     switch (entityType.toUpperCase()) {
//         case 'ORG':
//         case 'ORGANIZATION':
//             entities.organizations.push(cleanText);
//             break;
//         case 'PER':
//         case 'PERSON':
//             entities.persons.push(cleanText);
//             break;
//         case 'LOC':
//         case 'LOCATION':
//             entities.locations.push(cleanText);
//             break;
//         case 'DATE':
//         case 'TIME':
//             entities.dates.push(cleanText);
//             break;
//         case 'MONEY':
//         case 'PRICE':
//             entities.money.push(cleanText);
//             break;
//         default:
//             entities.misc.push(cleanText);
//     }
// }

// function extractProductsWithCurrency(text, currencies) {
//     const products = [];
//     const lines = text.split('\n');

//     // Enhanced product patterns that handle both USD and LBP
//     const productPatterns = [
//         // Product name followed by LBP price
//         /^(.+?)\s+(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:LL|L\.L\.|LBP|ل\.ل|ليرة)\s*$/i,
//         // Product name followed by USD price
//         /^(.+?)\s+\$?(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:USD|usd|\$)?\s*$/,
//         // Quantity + Product + LBP Price
//         /^(\d+)\s+(.+?)\s+(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:LL|L\.L\.|LBP|ل\.ل|ليرة)\s*$/i,
//         // Quantity + Product + USD Price
//         /^(\d+)\s+(.+?)\s+\$?(\d+(?:,\d{3})*(?:\.\d{2})?)\s*(?:USD|usd|\$)?\s*$/,
//         // Product with price at end (generic)
//         /^(.+?)\s+(\d+(?:,\d{3})*(?:\.\d{2})?)\s*$/
//     ];

//     for (const line of lines) {
//         const cleanLine = line.trim();
//         if (cleanLine.length < 3) continue;

//         // Skip header lines
//         if (/^(item|product|description|qty|quantity|price|total|subtotal|tax|invoice|receipt)/i.test(cleanLine)) {
//             continue;
//         }

//         for (const pattern of productPatterns) {
//             const match = cleanLine.match(pattern);
//             if (match) {
//                 let productName, price, quantity = 1, currency = 'USD';

//                 if (match.length === 3) {
//                     // Simple pattern: name + price
//                     productName = match[1].trim();
//                     price = parseFloat(match[2].replace(/,/g, ''));

//                     // Detect currency from original line
//                     if (/(?:LL|L\.L\.|LBP|ل\.ل|ليرة)/i.test(cleanLine)) {
//                         currency = 'LBP';
//                     }
//                 } else if (match.length === 4) {
//                     // Quantity + name + price
//                     quantity = parseInt(match[1]);
//                     productName = match[2].trim();
//                     price = parseFloat(match[3].replace(/,/g, ''));

//                     // Detect currency from original line
//                     if (/(?:LL|L\.L\.|LBP|ل\.ل|ليرة)/i.test(cleanLine)) {
//                         currency = 'LBP';
//                     }
//                 }

//                 if (productName && price && price > 0) {
//                     const product = {
//                         name: productName,
//                         originalPrice: price,
//                         originalCurrency: currency,
//                         quantity: quantity,
//                         priceUSD: currency === 'LBP' ? convertLBPToUSD(price) : price,
//                         totalUSD: currency === 'LBP' ? convertLBPToUSD(price * quantity) : (price * quantity),
//                         wasConverted: currency === 'LBP'
//                     };

//                     products.push(product);
//                 }
//                 break;
//             }
//         }
//     }

//     return products;
// }

// async function autoFillForm(entities, originalText) {
//     const filledFields = [];

//     // Fill store name
//     if (entities.organizations.length > 0) {
//         const storeField = document.querySelector('input[name="store_name"]');
//         if (storeField && !storeField.value) {
//             storeField.value = entities.organizations[0];
//             storeField.style.backgroundColor = '#e8f5e8';
//             filledFields.push('store name');
//         }
//     }

//     // Fill date
//     if (entities.dates.length > 0) {
//         const dateField = document.querySelector('input[name="purchase_date"]');
//         if (dateField && !dateField.value) {
//             const formattedDate = formatDateForInput(entities.dates[0]);
//             if (formattedDate) {
//                 dateField.value = formattedDate;
//                 dateField.style.backgroundColor = '#e8f5e8';
//                 filledFields.push('purchase date');
//             }
//         }
//     }

//     // Try to extract date from text patterns
//     if (filledFields.indexOf('purchase date') === -1) {
//         const dateField = document.querySelector('input[name="purchase_date"]');
//         if (dateField && !dateField.value) {
//             const extractedDate = extractDateFromText(originalText);
//             if (extractedDate) {
//                 dateField.value = extractedDate;
//                 dateField.style.backgroundColor = '#e8f5e8';
//                 filledFields.push('purchase date');
//             }
//         }
//     }

//     return filledFields;
// }

// function extractDateFromText(text) {
//     const datePatterns = [
//         /(\d{4})-(\d{1,2})-(\d{1,2})/g,
//         /(\d{1,2})\/(\d{1,2})\/(\d{4})/g,
//         /(\d{1,2})-(\d{1,2})-(\d{4})/g,
//         /(\d{4})\/(\d{1,2})\/(\d{1,2})/g,
//         /(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+(\d{1,2}),?\s+(\d{4})/gi
//     ];

//     for (const pattern of datePatterns) {
//         const match = pattern.exec(text);
//         if (match) {
//             return formatDateForInput(match[0]);
//         }
//     }
//     return null;
// }

// function formatDateForInput(rawDate) {
//     const datePatterns = [
//         /(\d{4})-(\d{1,2})-(\d{1,2})/,
//         /(\d{1,2})\/(\d{1,2})\/(\d{4})/,
//         /(\d{1,2})-(\d{1,2})-(\d{4})/,
//         /(\d{4})\/(\d{1,2})\/(\d{1,2})/,
//     ];

//     for (const pattern of datePatterns) {
//         const match = rawDate.match(pattern);
//         if (match) {
//             let [, first, second, third] = match;
//             let year, month, day;

//             if (first.length === 4) {
//                 year = first;
//                 month = second;
//                 day = third;
//             } else if (third.length === 4) {
//                 year = third;
//                 month = first;
//                 day = second;
//             } else {
//                 continue;
//             }

//             month = month.padStart(2, '0');
//             day = day.padStart(2, '0');

//             return `${year}-${month}-${day}`;
//         }
//     }
//     return null;
// }

// function showProductTable(products) {
//     const tableContainer = document.getElementById('product-table');
//     const tableBody = document.getElementById('product-table-body');

//     if (!tableContainer || !tableBody) {
//         console.error("Product table elements not found");
//         return;
//     }

//     // Clear existing rows
//     tableBody.innerHTML = '';

//     // Add products to table
//     products.forEach((product, index) => {
//         const row = document.createElement('tr');
//         row.className = 'product-row';

//         // Create price display with conversion info
//         let priceDisplay = '';
//         if (product.wasConverted) {
//             priceDisplay = `
//                 <div class="converted-price">$${product.priceUSD.toFixed(2)}</div>
//                 <div class="original-price">${formatCurrency(product.originalPrice, 'LBP')}</div>
//                 <div class="currency-info">Converted at 1$ = 90,000 LL</div>
//             `;
//         } else {
//             priceDisplay = `<div>$${product.priceUSD.toFixed(2)}</div>`;
//         }

//         if (product.quantity > 1) {
//             priceDisplay += `<div class="text-sm text-gray-600">Total: $${product.totalUSD.toFixed(2)}</div>`;
//         }

//         row.innerHTML = `
//             <td class="p-2 border">
//                 <div><strong>${product.name}</strong></div>
//                 <div class="text-sm text-gray-600">Qty: ${product.quantity}</div>
//             </td>
//             <td class="p-2 border">
//                 ${priceDisplay}
//             </td>
//             <td class="p-2 border text-center">
//                 <button class="select-button" onclick="selectProduct('${product.name}', ${product.priceUSD}, ${product.wasConverted ? 'true' : 'false'}, ${product.originalPrice}, '${product.originalCurrency}')">
//                     Select
//                 </button>
//             </td>
//         `;
//         tableBody.appendChild(row);
//     });

//     // Show the table
//     tableContainer.style.display = 'block';
// }

// // Updated function to select a product with currency info
// function selectProduct(productName, priceUSD, wasConverted, originalPrice, originalCurrency) {
//     // Fill the form with selected product
//     const productSelect = document.querySelector('select[name="product_select"]');
//     const priceField = document.querySelector('input[name="price"]');

//     if (productSelect) {
//         // Check if product exists in dropdown
//         const existingOption = Array.from(productSelect.options).find(option =>
//             option.value.toLowerCase() === productName.toLowerCase()
//         );

//         if (existingOption) {
//             productSelect.value = existingOption.value;
//         } else {
//             // Select "add new product" option
//             productSelect.value = 'add_new';
//             productSelect.dispatchEvent(new Event('change'));

//             // Fill new product name
//             setTimeout(() => {
//                 const newProductField = document.querySelector('input[name="name"]');
//                 if (newProductField) {
//                     newProductField.value = productName;
//                     newProductField.style.backgroundColor = '#e8f5e8';
//                 }
//             }, 100);
//         }
//     }

//     // Fill price (always in USD)
//     if (priceField) {
//         priceField.value = priceUSD.toFixed(2);
//         priceField.style.backgroundColor = '#e8f5e8';
//     }

//     // Highlight selected row
//     const rows = document.querySelectorAll('.product-row');
//     rows.forEach(row => row.classList.remove('selected'));
//     event.target.closest('.product-row').classList.add('selected');

//     // Show appropriate success message
//     let message = `Selected product: ${productName} - $${priceUSD.toFixed(2)}`;
//     if (wasConverted === 'true') {
//         message += ` (converted from ${formatCurrency(originalPrice, originalCurrency)})`;
//     }

//     showPopup(message, 'success');
// }

// // Initialize when DOM is loaded
// document.addEventListener('DOMContentLoaded', () => {
//     console.log("DOM loaded, initializing AI system...");

//     // Initialize popup styles
//     initializePopupStyles();

//     // Initialize NER
//     initializeNER();

//     // Listen for OCR results
//     const ocrTextarea = document.getElementById('ocr-result');
//     if (ocrTextarea) {
//         ocrTextarea.addEventListener('change', handleOCRResult);
//         ocrTextarea.addEventListener('input', handleOCRResult);
//     }
// });

// function handleOCRResult() {
//     const text = document.getElementById('ocr-result').value;
//     if (text && text.length > 10) {
//         console.log("OCR result detected, starting AI analysis...");
//         runNER(text);
//     }
// }

// // Export functions for global use
// window.runNER = runNER;
// window.initializeNER = initializeNER;
// window.selectProduct = selectProduct;
// window.detectCurrency = detectCurrency;
// window.convertLBPToUSD = convertLBPToUSD;
// window.convertUSDToLBP = convertUSDToLBP;


