@extends('Admin.Layouts.app')

@section('title', 'Edit Product')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/product-add.css') }}">
@endpush

@section('page-content')

<div class="admin-layout">

    <main class="admin-content">
        <div class="container">
            <div class="page-header">
                <div class="breadcrumb">
                    <a href="/admin/products" class="breadcrumb-link">Products</a>
                    <i class="fas fa-chevron-right"></i>
                    <span class="breadcrumb-current">Edit Product</span>
                </div>
            </div>

            <div class="add-form-card">
                <div class="card-header">
                    <h2 class="card-title">Edit Product</h2>
                    <p class="card-description">Update product details and pricing information.</p>
                </div>

                <form class="product-form" method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="productName">Product Name *</label>
                            <input type="text" id="productName"  value="{{ $product->name}}" readonly>

                        </div>


                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select id="category" name="category" required>
                                <option value="" disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="error">
                                    <div class="error__icon">
                                        <!-- error svg icon -->
                                    </div>
                                    <div class="error__title">{{ $message }}</div>
                                    <div class="error__close">
                                        <!-- close icon svg -->
                                    </div>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="storeName">Store Name *</label>
                            <input type="text" id="storeName" name="store_name" placeholder="Enter Store Name" value="{{ old('store_name', $product->store_name) }}">
                            @error('store_name')
                                <div class="error">
                                    <div class="error__icon">
                                        <!-- error svg icon -->
                                    </div>
                                    <div class="error__title">{{ $message }}</div>
                                    <div class="error__close">
                                        <!-- close icon svg -->
                                    </div>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="productId">Product ID</label>
                            <input type="text" id="productId" placeholder="Auto-generated" value="{{ $product->id }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="Price">Price($) *</label>
                            <input type="number" id="Price" name="price" placeholder="0.00" step=0.01
                             min="0" value="{{ old('price', $product->price) }}">
                            @error('price')
                                <div class="error">
                                    <div class="error__icon">
                                        <!-- error svg icon -->
                                    </div>
                                    <div class="error__title">{{ $message }}</div>
                                    <div class="error__close">
                                        <!-- close icon svg -->
                                    </div>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="purchaseDate">Purchase Date *</label>
                            <input type="date" id="purchaseDate" name="purchase_date" placeholder="mm/dd/yyyy" required value="{{ old('purchase_date', $product->purchase_date ? $product->purchase_date->format('Y-m-d') : '') }}">
                            @error('purchase_date')
                                <div class="error">
                                    <div class="error__icon">
                                        <!-- error svg icon -->
                                    </div>
                                    <div class="error__title">{{ $message }}</div>
                                    <div class="error__close">
                                        <!-- close icon svg -->
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="image-section">
                        <div>
                            <h3>Product Image</h3>
                            <div class="image-upload">
                                <div class="upload-area" id="upload-area-admin-image" style="{{ $product->image_path ? 'display:none;' : '' }}">
                                    <input type="file" id="adminImageUpload" name="image_path" accept="image/*" hidden>
                                    <label for="adminImageUpload" class="upload-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Click to upload product image</span>
                                        <small>PNG, JPG up to 5MB</small>
                                    </label>
                                    @error('image_path')
                                        <div class="error">
                                            <div class="error__icon">
                                                <!-- error svg icon -->
                                            </div>
                                            <div class="error__title">{{ $message }}</div>
                                            <div class="error__close">
                                                <!-- close icon svg -->
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                                <div class="preview-area" id="preview-area-admin-image" style="{{ $product->image_path ? '' : 'display:none;' }}">
                                    <img id="previewImageAdmin" src="{{ asset($product->image_path) }}" alt="Product preview">
                                    <button type="button" class="remove-image" id="removeAdminImage">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3>Invoice Image</h3>
                            <div class="invoice-upload">
                                <div class="upload-area" id="upload-area-admin-invoice" style="{{ $product->invoice ? 'display:none;' : '' }}">
                                    <input type="file" id="adminInvoiceUpload" name="invoice" accept="image/*" hidden>
                                    <label for="adminInvoiceUpload" class="upload-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Click to upload invoice image</span>
                                        <small>PNG, JPG up to 5MB</small>
                                    </label>
                                    @error('invoice')
                                        <div class="error">
                                            <div class="error__icon">
                                                <!-- error svg icon -->
                                            </div>
                                            <div class="error__title">{{ $message }}</div>
                                            <div class="error__close">
                                                <!-- close icon svg -->
                                            </div>
                                        </div>
                                    @enderror
                                </div>
                                <div class="preview-area" id="preview-area-admin-invoice" style="{{ $product->invoice ? '' : 'display:none;' }}">
                                    <img id="previewInvoiceAdmin" src="{{ asset($product->invoice) }}" alt="Invoice preview">
                                    <button type="button" class="remove-image" id="removeAdminInvoice">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="/admin/products" name="product_cancel" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="submit" name="product_btn" class="btn-save">
                            <i class="fas fa-save"></i>
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/admin/product-add.js') }}"></script>
@endpush

@endsection
