@extends('Admin.Layouts.app')

@section('title', 'View Category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/category-view.css') }}">
@endpush

@section('page-content')

    <!-- Category View Page -->
    <div class="admin-container">
        <!-- Header Section -->
        <div class="admin-page-header">
            <div class="breadcrumb">
                <a href="/admin/categories" class="breadcrumb-link">Categories</a>
                <i class="fas fa-chevron-right"></i>
                <span class="breadcrumb-current">Category Details</span>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.categories.edit',$category->id) }}" class="btn-secondary">
                    <i class="fas fa-pencil-alt"></i>
                    Edit Category
                </a>

            </div>
        </div>

        <!-- Category Details Card -->
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Category Information</h2>
            </div>
            <div class="card-content">
                <div class="details-grid">
                    <div class="detail-item">
                        <label class="detail-label">Category Name</label>
                        <p class="detail-value" id="category-name">{{ $category->name }}</p>
                    </div>
                    <div class="detail-item">
                        <label class="detail-label">Product Count</label>
                        <p class="detail-value" id="category-product-count">{{ $productCount }}</p>
                    </div>

                    <div class="detail-item">
                        <label class="detail-label">Date Created</label>
                        <p class="detail-value" id="category-date-created">{{ $category->created_at }}</p>
                    </div>
                    <div class="detail-item full-width">
                        <label class="detail-label">Description</label>
                        <p class="detail-value" id="category-description">{{ $category->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Products Card -->
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Products in this Category</h2>
            </div>
            <div class="card-content">
                <div class="products-grid">
                    <!-- Products will be loaded here -->
                    @foreach ($products as $product)
                        <div class="product-item">
                            <img src="{{ asset($product->image_path )}}" alt="Product" class="product-image">
                            <div class="product-info">
                                <h4 class="product-name">{{ $product->name }}</h4>
                                <p class="product-price">${{ $product->min_price }} - ${{ $product->max_price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
