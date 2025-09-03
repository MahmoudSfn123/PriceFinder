@extends('Admin.Layouts.app')

@section('title', 'Categories')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/categories.css') }}">
@endpush

@section('page-content')



    <!-- Products Content -->
    <main class="admin-content">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Categories</h1>
                <a href="{{ route('admin.categories.create') }}" class="add-button">
                    <i class="fas fa-plus"></i>
                    Add Category
                </a>
            </div>

            <!-- Products Table Card -->
            <div class="products-card">
                <div class="card-header">
                    <h2 class="card-title">All Categories</h2>
                    <div class="search-container">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" placeholder="Filter by name..." class="search-input">
                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <div class="table-container">
                        <table class="products-table">
                            <thead>
                                <tr class="table-header">
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th style="text-align: center">Description</th>
                                    <th class="text-right">Number of Product</th>
                                    <th class="text-center actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="table-row">
                                        <td class="product-name">{{ $category->name }}</td>
                                        <td><img class="entry-image" src="{{ asset($category->imagepath) }}"
                                                alt="{{ $category->name }}"></td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-right">{{ $category->products_count }}</td>

                                        <td class="actions-dropdown">
                                            <button class="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                                    class="dropdown-item view">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    View Products
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="dropdown-item edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>

                                                <form id="deleteForm-{{ $category->id }}"
                                                    action="{{ route('admin.categories.destroy', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="background-color: transparent;border:none" type="submit"
                                                        class="dropdown-item delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container" data-current-page="{{ $categories->currentPage() }}"
                        data-last-page="{{ $categories->lastPage() }}">
                        <div class="pagination">
                            <button class="pagination-btn prev"
                                @if (!$categories->onFirstPage()) data-url="{{ $categories->previousPageUrl() }}" @else disabled @endif>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>

                            <div class="pagination-numbers">
                                @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                    <button class="page-number {{ $i == $categories->currentPage() ? 'active' : '' }}"
                                        data-url="{{ $categories->url($i) }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>

                            <button class="pagination-btn next"
                                @if ($categories->hasMorePages()) data-url="{{ $categories->nextPageUrl() }}" @else disabled @endif>
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
