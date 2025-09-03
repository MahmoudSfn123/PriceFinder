@extends('Admin.Layouts.app')

@section('title', 'Edit Category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/category-add.css') }}">
@endpush

@section('page-content')
    <div class="admin-layout">
        <main class="admin-content">
            <div class="container">
                <div class="page-header">
                    <div class="breadcrumb">
                        <a href="/admin/categories" class="breadcrumb-link">Categories</a>
                        <i class="fas fa-chevron-right"></i>
                        <span class="breadcrumb-current">Edit Category</span>
                    </div>
                </div>

                <div class="add-form-card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Category</h2>
                        <p class="card-description">Update Category Details</p>
                    </div>

                    <form class="product-form" method="POST" action="{{ route('admin.categories.update', $category->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            {{-- Category Name --}}
                            <div class="form-group">
                                <label for="name">Category Name *</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $category->name) }}" placeholder="Enter category name"
                                    class="@error('name') is-invalid @enderror">

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

                            {{-- Category ID (read-only display) --}}
                            <div class="form-group">
                                <label for="productId">Category ID</label>
                                <input type="text" id="productId" value="{{ $category->id }}" readonly>
                            </div>

                            {{-- Description --}}
                            <div class="form-group half-width">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="5" placeholder="Enter description"
                                    class="@error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                                @error('description')
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

                            {{-- Image Upload --}}
                            <div class="form-group half-width">
                                <label for="imagepath">Category Image</label>

                                {{-- Existing Image Preview --}}

                                <div class="preview-area" id="preview-area-admin-image" style="display: block;">
                                    <img id="previewImageAdmin" src="{{ asset($category->imagepath) }}" alt="Category Image"
                                        style="max-width: 200px;">
                                    <button type="button" class="remove-image" id="removeAdminImage">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>


                                <div class="image-section">
                                    <div class="image-upload">
                                        <div class="upload-area" id="upload-area-admin-image"
                                            style="{{ $category->imagepath ? 'display: none;' : '' }}">
                                            <input type="file" id="adminImageUpload" name="imagepath" accept="image/*"
                                                hidden>
                                            <label for="adminImageUpload" class="upload-label">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <span>Click to upload category image</span>
                                                <small>PNG, JPG up to 5MB</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('imagepath')
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
                                                    <button class="error__close"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="20" viewBox="0 0 20 20" height="20">
                                                            <path fill="#393a37"
                                                                d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                                            </path>
                                                        </svg></button>
                                                </div>
                                            @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="form-actions">
                            <a href="/admin/categories" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Save Changes
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
