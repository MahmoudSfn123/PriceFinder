 <x-app-layout title='Add Product'>

     <x-slot:firstpage>
         <div class="breadcrumb-section breadcrumb-bg">
             <div class="container">
                 <div class="row">
                     <div class="col-lg-8 offset-lg-2 text-center">
                         <div class="breadcrumb-text">
                             <p>Find the Best Price</p>
                             <h1>Add Product</h1>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </x-slot:firstpage>


     <main class="container">
         <div id="product-table" class="card" style="display:none; margin-bottom: 1.5rem;margin-top:1.9rem;">
             <div class="card-header">
                 <h3 class="card-title">
                     <i class="fa-solid fa-list-check" style="color: #F28123;"></i>
                     Products Found in Invoice
                 </h3>
             </div>
             <div class="card-content">
                 <table class="table-auto w-full border text-sm">
                     <thead class="bg-gray-100 text-left">
                         <tr>
                             <th class="p-2 border">Product</th>
                             <th class="p-2 border">Price</th>
                             <th class="p-2 border text-center">Select</th>
                         </tr>
                     </thead>
                     <tbody id="product-table-body" class="text-gray-800"></tbody>
                 </table>
             </div>
         </div>

         <form id="product-form" class="form" style="margin-top:5%;" method="POST"
             action="{{ route('products.store') }}" enctype="multipart/form-data">
             @csrf
             <div style="padding: 2rem 0;">
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                     <!-- Invoice Uploader -->
                     <div class="card">
                         <div class="card-header">
                             <h2 class="card-title">
                                 <i class="fa-solid fa-receipt icon-primary"></i>
                                 Upload Your Invoice / Product Image
                             </h2>
                             <p class="card-description">
                                 Drag and drop your file or click to browse files
                             </p>
                         </div>
                         {{-- <input type="hidden" name="invoice_path" id="invoice_path"> --}}


                         <div class="card-content">
                             <!-- ✅ Make upload-area a label and link it to input -->
                             <label id="upload-area-invoice" class="upload-area cursor-pointer">
                                 <i class="fa-solid fa-receipt icon-large text-gray"></i>
                                 <p class="upload-text">
                                     <span class="font-semibold">Click to upload</span> invoice photo
                                 </p>
                                 <p class="upload-hint">JPG, PNG, or JPEG (max 5MB)</p>

                                 <!-- ✅ Hidden input inside label -->
                                 <input name="invoice" id="file-upload" type="file" class="hidden"
                                     accept=".png,.jpg,.jpeg">
                             </label>
                             @error('invoice')
                                 <div class="error">
                                     <div class="error__icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                             height="24" fill="none">
                                             <path fill="#393a37"
                                                 d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                             </path>
                                         </svg>
                                     </div>
                                     <div class="error__title">{{ $message }}</div>
                                     <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                             viewBox="0 0 20 20" height="20">
                                             <path fill="#393a37"
                                                 d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                             </path>
                                         </svg></div>
                                 </div>
                             @enderror
                             {{-- <textarea id="ocr-result" rows="10" cols="60" placeholder="OCR result will appear here..." style="display: none;"></textarea> --}}
                             <div id="file-preview-invoice" class="file-preview hidden">
                                 <div class="file-info">
                                     <div class="file-icon">
                                         <i class="fa-solid fa-receipt icon-primary"></i>
                                     </div>
                                     <div class="file-details">
                                         <p class="file-name">invoice.pdf</p>
                                         <p class="file-size">123.45 KB</p>
                                     </div>
                                 </div>
                                 <button id="remove-file-invoice" class="remove-button">Remove</button>
                             </div>
                         </div>
                         <div class="card-content">
                             <!-- ✅ Make upload-area a label and link it to input -->
                             <label id="upload-area-image" class="upload-area cursor-pointer">
                                 <i class="fa-solid fa-image icon-large text-gray"></i>
                                 <p class="upload-text">
                                     <span class="font-semibold">Click to upload </span> product photo
                                 </p>
                                 <p class="upload-hint">JPG, PNG, or JPEG (max 5MB)</p>

                                 <!-- ✅ Hidden input inside label -->
                                 <input name="image_path" value="" id="file-upload-image" type="file"
                                     class="hidden" accept="png,.jpg,.jpeg">
                             </label>
                             @error('image_path')
                                 <div class="error">
                                     <div class="error__icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                             height="24" fill="none">
                                             <path fill="#393a37"
                                                 d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                             </path>
                                         </svg>
                                     </div>
                                     <div class="error__title">{{ $message }}</div>
                                     <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                             viewBox="0 0 20 20" height="20">
                                             <path fill="#393a37"
                                                 d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                             </path>
                                         </svg></div>
                                 </div>
                             @enderror

                             <div id="file-preview-image" class="file-preview hidden">
                                 <div class="file-info">
                                     <div class="file-icon">
                                         <i class="fa-solid fa-receipt icon-primary"></i>
                                     </div>
                                     <div class="file-details">
                                         <p class="file-name">invoice.pdf</p>
                                         <p class="file-size">123.45 KB</p>
                                     </div>
                                 </div>
                                 <button id="remove-file-image" class="remove-button">Remove</button>
                             </div>
                         </div>
                     </div>




                     <!-- Product Form -->
                     <div class="card">
                         <div class="card-header">
                             <h2 class="card-title">
                                 <i class="fa-solid fa-shopping-bag icon-primary"></i>
                                 Product Details
                             </h2>
                             <p class="card-description">
                                 Enter information about the product you want to compare
                             </p>
                         </div>
                         <div class="card-content">

                             <div class="form-group">
                                 <label for="product-select" class="form-label">Product Name</label>
                                 <select id="product-select" name="product_select" class="form-select"
                                     @error('product_select') is-invalid @enderror required>
                                     <option value="" disabled selected>Select a product</option>
                                     @foreach ($products as $item)
                                         <option value="{{ $item->name }}">
                                             {{ $item->name }}
                                         </option>
                                     @endforeach
                                     <option value="add_new">➕ Add new product</option>
                                 </select>
                                 @error('product_select')
                                     <div class="error-message">{{ $message }}</div>
                                 @enderror
                             </div>


                             <!-- Hidden new product name input -->
                             <div class="form-group" id="new-product-name-group" style="display: none;">
                                 <label for="name" class="form-label">New Product Name</label>
                                 <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}"
                                     @error('name') is-invalid @enderror placeholder="Enter new product name"
                                     >
                                 @error('name')
                                     <div class="error">
                                         <div class="error__icon">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                                 height="24" fill="none">
                                                 <path fill="#393a37"
                                                     d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                                 </path>
                                             </svg>
                                         </div>
                                         <div class="error__title">{{ $message }}</div>
                                         <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                 viewBox="0 0 20 20" height="20">
                                                 <path fill="#393a37"
                                                     d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                                 </path>
                                             </svg></div>
                                     </div>
                                 @enderror
                             </div>


                             <div class="form-group">
                                 <label for="category" class="form-label">Category</label>
                                 <select id="category" name="category" class="form-select"
                                     @error('category') is-invalid @enderror required>
                                     <option  disabled selected>Select a category</option>
                                     @foreach ($category as $item)
                                         <option value="{{ $item->id }}"
                                            >
                                             {{ $item->name }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>

                             <div class="form-group">
                                 <label for="purchase_date" class="form-label"
                                     @error('purchase_date') is-invalid @enderror>Purchase Date</label>
                                 <input type="date"  name="purchase_date"
                                     id="purchase_date" class="form-input" value="{{ old('purchase_date') }}"
                                     placeholder="e.g. Unlocked, New, Used, With AppleCare" required>
                                 @error('purchase_date')
                                     <div class="error">
                                         <div class="error__icon">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                                 height="24" fill="none">
                                                 <path fill="#393a37"
                                                     d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                                 </path>
                                             </svg>
                                         </div>
                                         <div class="error__title">{{ $message }}</div>
                                         <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                 viewBox="0 0 20 20" height="20">
                                                 <path fill="#393a37"
                                                     d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                                 </path>
                                             </svg></div>
                                     </div>
                                 @enderror
                             </div>

                             <div class="form-row">
                                 <div class="form-group half-width ">
                                     <label for="price" class="form-label">Price</label>
                                     <input type="text"  id="price" value="{{ old('price') }}"
                                         name="price" class="form-input" {{ $errors->has('price') ? 'error' : '' }}
                                         placeholder="e.g. 999.99" step="0.01" min="0" required>
                                     @error('price')
                                         <!-- From Uiverse.io by andrew-demchenk0 -->
                                         <div class="error">
                                             <div class="error__icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                     viewBox="0 0 24 24" height="24" fill="none">
                                                     <path fill="#393a37"
                                                         d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                                     </path>
                                                 </svg>
                                             </div>
                                             <div class="error__title">{{ $message }}</div>
                                             <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg"
                                                     width="20" viewBox="0 0 20 20" height="20">
                                                     <path fill="#393a37"
                                                         d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                                     </path>
                                                 </svg></div>
                                         </div>
                                     @enderror
                                 </div>
                                 <div class="form-group half-width">
                                     <label for="store_name" class="form-label">Store</label>
                                     <input type="text"  name="store_name" value="{{ old('store_name') }}"
                                         class="form-input" {{ $errors->has('store_name') ? 'error' : '' }}
                                         placeholder="e.g. Best Buy" required>
                                     @error('store_name')
                                         <div class="error">
                                             <div class="error__icon">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                     viewBox="0 0 24 24" height="24" fill="none">
                                                     <path fill="#393a37"
                                                         d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                                     </path>
                                                 </svg>
                                             </div>
                                             <div class="error__title">{{ $message }}</div>
                                             <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg"
                                                     width="20" viewBox="0 0 20 20" height="20">
                                                     <path fill="#393a37"
                                                         d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                                     </path>
                                                 </svg></div>
                                         </div>
                                     @enderror
                                 </div>
                             </div>

                             <div class="form-group">
                                 <button type="submit" name="product-btn" class="boxed-btn"
                                     style="margin-top:40px !important;">Add your Product</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </form>


     </main>


 </x-app-layout>

<script src="{{ asset('assets/js/ocr-code.js') }}"></script>
{{-- <script type="module" src="{{ asset('assets/js/ner-code.js') }}"></script> --}}


