@extends('Admin.Layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
@endpush

@section('page-content')

    <div class="dashboard-container">
        <h1 class="dashboard-title">Dashboard</h1>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card products">
                <div class="stat-header">
                    <span class="stat-label">Total Products</span>
                    <i class="fas fa-database stat-icon"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $products->count() }}</div>
                    <p class="stat-change">+20.1% from last month</p>
                </div>
            </div>

            <div class="stat-card categories">
                <div class="stat-header">
                    <span class="stat-label">Total Categories</span>
                    <i class="fas fa-tag stat-icon"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $categories->count() }}</div>
                    <p class="stat-change">+12% from last month</p>
                </div>
            </div>

            <div class="stat-card users">
                <div class="stat-header">
                    <span class="stat-label">Active Users</span>
                    <i class="fas fa-users stat-icon"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $users->count() }}</div>
                    <p class="stat-change">+19% from last month</p>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="tables-grid">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">Recent Products</h3>
                    <a href="/admin/products" class="view-all-link">
                        View All <i class="fas fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>AVG Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distinctProducts as $distinctProduct)
                                <tr>
                                    <td class="product-name">{{ $distinctProduct->name }}</td>
                                    <td>{{ $distinctProduct->category_name }}</td>
                                    <td class="price">${{ number_format($distinctProduct->avg_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">Top Categories</h3>
                    <a href="/admin/categories" class="view-all-link">
                        View All <i class="fas fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
                <div class="categories-list">
                    @foreach ($categories as $category)
                        <div class="category-item">
                            <span class="category-name">{{ $category->name }}</span>
                            <span class="category-count">{{ $category->products_count }} products</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
