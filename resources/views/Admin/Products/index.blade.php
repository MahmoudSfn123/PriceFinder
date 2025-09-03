@extends('Admin.Layouts.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">
@endpush

@section('page-content')



            <!-- Products Content -->
            <main class="admin-content">
                <div class="container">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">Products</h1>
                        <a href="{{ route('admin.products.create') }}" class="add-button">
                            <i class="fas fa-plus"></i>
                            Add Product
                        </a>
                    </div>

                    <!-- Products Table Card -->
                    <div class="products-card">
                        <div class="card-header">
                            <h2 class="card-title">All Products</h2>
                            <div class="search-container">
                                <div class="search-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchInput" placeholder="Filter by name..."
                                        class="search-input">
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="table-container">
                                <table class="products-table">
                                    <thead>
                                        <tr class="table-header">
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th class="text-right">Price Range</th>
                                            <th class="text-right">Number of Product</th>
                                            <th class="text-center actions-column">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr class="table-row">
                                                <td class="product-name">{{ $product->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td class="text-right price-range">
                                                    <span style="color: green;">
                                                        ${{ number_format($product->min_price, 2) }}
                                                    </span>
                                                    -
                                                    <span style="color: red;">
                                                        ${{ number_format($product->max_price, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">{{ $product->total }}</td>
                                                <td class="text-center">
                                                        <a href="{{ route('admin.products.show', $product->name) }}"
                                                            class="dropdown-item view">
                                                            <i class="fas fa-eye"></i>
                                                            View
                                                        </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container" data-current-page="{{ $products->currentPage() }}"
                                data-last-page="{{ $products->lastPage() }}">
                                <div class="pagination">
                                    <button class="pagination-btn prev"
                                        @if (!$products->onFirstPage()) data-url="{{ $products->previousPageUrl() }}" @else disabled @endif>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>

                                    <div class="pagination-numbers">
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <button
                                                class="page-number {{ $i == $products->currentPage() ? 'active' : '' }}"
                                                data-url="{{ $products->url($i) }}">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>

                                    <button class="pagination-btn next"
                                        @if ($products->hasMorePages()) data-url="{{ $products->nextPageUrl() }}" @else disabled @endif>
                                        Next <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
    @push('scripts')
        <script src="{{ asset('assets/js/admin/products.js') }}"></script>
    @endpush

@endsection
