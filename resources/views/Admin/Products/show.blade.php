@extends('Admin.Layouts.app')

@section('title', 'Product Details')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/products-view.css') }}">
@endpush

@section('page-content')

    <div class="admin-layout">

        <main class="admin-content">
            <div class="container">
                <div class="page-header">
                    <div class="breadcrumb">
                        <a href="/admin/products" class="breadcrumb-link">Products</a>
                        <i class="fas fa-chevron-right"></i>
                        <span class="breadcrumb-current">View Product</span>
                    </div>
                    <div class="header-actions">
                        {{-- <a href="{{ route('admin.products.select') }}" class="btn-secondary">
                        <i class="fas fa-pencil-alt"></i>
                        Edit Product
                    </a> --}}
                        <button class="btn-danger">
                            <i class="fas fa-trash-alt"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <div class="product-view-card">
                    <div class="product-header">
                        <div class="product-image">
                            <img id="productImage" src="{{ asset($products->first()->image_path) }}" alt="Product Image">
                        </div>
                        <div class="product-title-section">
                            <h1 id="productTitle" class="product-title">{{ $productName }}</h1>
                            <div class="product-meta">
                                <span id="categoryBadge" class="category-badge">{{ $category->name }}</span>
                                <span id="stockStatus" class="stock-status in-stock">In Stock</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-details">
                        <div class="details-grid">
                            <div class="detail-item">
                                <label>Category</label>
                                <span id="productCategory">{{ $category->name }}</span>
                            </div>
                            <div class="detail-item">
                                <label>Number of Product</label>
                                <span id="stockQuantity">{{ $products->count() }}</span>
                            </div>

                            <div class="detail-item">
                                <label>Last Updated</label>
                                <span id="lastUpdated">{{ $lastUpdated }}</span>
                            </div>
                        </div>

                        <div class="price-section">
                            <h3>Price Information</h3>
                            <div class="price-grid">
                                <div class="price-item">
                                    <label>Lowest Price</label>
                                    <span id="lowestPrice" class="lowestprice">${{ $lowestPrice }}</span>
                                </div>
                                <div class="price-item">
                                    <label>Highest Price</label>
                                    <span id="highestPrice" class="highestprice">${{ $highestPrice }}</span>
                                </div>
                                <div class="price-item">
                                    <label>Average Price</label>
                                    <span id="averagePrice"
                                        class="averageprice">${{ number_format($averagePrice, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="store-entries" class="store-entries-section">
                <h3>All Store Entries</h3>
                <div class="store-entries-table">
                    <div class="store-entries-header">
                        <span>Product ID</span>
                        <span>Store</span>
                        <span>Image</span>
                        <span>Added By</span>
                        <span>Verified</span>
                        <span>Price</span>
                        <span>Purchase Date</span>
                        <span>Action</span>
                    </div>

                    @foreach ($products as $product)
                        <div class="store-entries-row">
                            <span style="text-align: center;"><b>{{ $product->id }}</b></span>
                            <span>{{ $product->store_name }}</span>
                            <span>
                                <img src="{{ asset($product->image_path) }}" class="entry-image" alt="Product Image">
                            </span>
                            <span>{{ $product->users->first()->first_name }}
                                {{ $product->users->first()->last_name }}</span>
                            <span class="{{ $product->verified ? 'verified' : 'not-verified' }}">
                                {{ $product->verified ? 'Verified' : 'Not Verified' }}
                            </span>
                            <span class="price-cell">${{ $product->price }}</span>
                            <span>{{ $product->created_at }}</span>
                            <span class="actions-dropdown">

                                <button class="actions-trigger">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="dropdown-item edit">
                                        <i class="fas fa-pencil-alt"></i>
                                        Edit
                                    </a>
                                    <div class="dropdown-separator"></div>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item delete">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- Pagination -->
            <div class="pagination-container" data-current-page="{{ $products->currentPage() }}"
                data-last-page="{{ $products->lastPage() }}">
                <div class="pagination">
                    <button class="pagination-btn prev"
                        @if (!$products->onFirstPage()) data-url="{{ $products->previousPageUrl() ? $products->previousPageUrl() . '#store-entries' : '' }}" @else disabled @endif>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>

                    <div class="pagination-numbers">
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <button class="page-number {{ $i == $products->currentPage() ? 'active' : '' }}"
                                data-url="{{ $products->url($i) . '#store-entries' }}">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>

                    <button class="pagination-btn next"
                        @if ($products->hasMorePages()) data-url="{{ $products->hasMorePages() ? $products->nextPageUrl() . '#store-entries' : '' }}" @else disabled @endif>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>



            <!-- Add this section after the product-view-card div and before the store-entries-section -->
            <div class="review-ratings-section">
    <div class="review-ratings-header">
        <h3>Customer Reviews & Ratings</h3>
    </div>

    <div class="review-ratings-content">
        <div class="ratings-overview">
            <div class="overall-rating">
                <div class="rating-number">{{ number_format($avgRating ?? 0, 1) }}</div>
                <div class="rating-section">
                    <i class="fas fa-star star-icon"></i>
                    <span class="rating-value">{{ number_format($avgRating ?? 0, 1) }}</span>
                </div>
                <div class="total-reviews">Based on {{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</div>
            </div>

            <div class="rating-breakdown">
                @for ($i = 5; $i >= 1; $i--)
                    <div class="rating-breakdown-item">
                        <div class="rating-stars">
                            @for ($j = 1; $j <= 5; $j++)
                                <i class="{{ $j <= $i ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <div class="rating-bar">
                            <div class="rating-bar-fill" style="width: {{ $ratingBreakdown[$i] ?? 0 }}%"></div>
                        </div>
                        <span class="rating-count">{{ $ratingCounts[$i] ?? 0 }}</span>
                    </div>
                @endfor
            </div>
        </div>

        <div class="recent-reviews">
            <h4>Recent Reviews</h4>

            @forelse ($recentReviews as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">
                                 @if ($review->user && $review->user->first_name && $review->user->last_name)
                                    {{ strtoupper(substr($review->user->first_name, 0, 1)) }}{{ strtoupper(substr($review->user->last_name, 0, 1)) }}
                                @else
                                    G
                                @endif
                            </div>
                            <div class="reviewer-details">
                                <h5>@if ($review->user && ($review->user->first_name || $review->user->last_name))
                                        {{ $review->user->first_name ?? '' }} {{ $review->user->last_name ?? '' }}
                                    @else
                                        Guest
                                    @endif
                                <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="review-text">
                        {{ $review->comment }}
                    </div>
                </div>
            @empty
                <p>No reviews available yet.</p>
            @endforelse

            <a href="{{ route('admin.reviews.index') }}" class="view-all-reviews">
                View All Reviews
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>


        </main>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/admin/product-view.js') }}"></script>
    @endpush
@endsection













