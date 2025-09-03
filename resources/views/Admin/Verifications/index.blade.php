@extends('Admin.Layouts.app')

@section('title', 'Verifications')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/products.css') }}">
@endpush

@section('page-content')

    <div class="admin-layout">
        <!-- Main Content Area -->
        <div class="admin-main">

            <!-- Products Content -->
            <main class="admin-content">
                <div class="container">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">Product Verification</h1>
                    </div>

                    <!-- Products Table Card -->
                    <div class="products-card">
                        <div class="card-header">
                            <h2 class="card-title">Pending Submissions</h2>
                            <div class="search-container">
                                <p>Review and approve or reject new product submissions from users.</p>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="table-container">
                                <table class="products-table">
                                    <thead>
                                        <tr class="table-header">
                                            <th>Product Name</th>
                                            <th>Store Name</th>
                                            <th>Added By</th>
                                            <th>Purchase Date</th>
                                            <th>Price</th>
                                            <th>Invoice</th>
                                            <th class="text-center actions-column">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr class="table-row">
                                                <td class="product-name">{{ $product->name }}</td>
                                                <td>{{ $product->store_name }}</td>
                                                <td>{{ $product->users->first()->first_name }}
                                                    {{ $product->users->first()->last_name }}</td>
                                                <td class="text-right">{{ $product->purchase_date }}</td>
                                                <td class="price-cell">${{ $product->price }}</td>
                                                <td><button class="btn btn-ghost btn-sm"
                                                        onclick="viewInvoice('{{ asset($product->invoice) }}')">
                                                        <i class="fas fa-file-text"></i>
                                                        View
                                                    </button></td>
                                                <td class="table-cell text-center">
                                                    <div class="action-buttons">
                                                        <button class="btn btn-success btn-sm approve-btn"
                                                            data-id="{{ $product->id }}"
                                                            onclick="updateVerification({{ $product->id }}, 1)"
                                                            {{ $product->verified == 0 ? '' : 'disabled' }}>
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>

                                                        <button class="btn btn-danger btn-sm reject-btn"
                                                            data-id="{{ $product->id }}"
                                                            onclick="updateVerification({{ $product->id }}, 0)"
                                                            {{ $product->verified == 0 ? 'disabled' : '' }}>
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    </div>
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
        </div>
    </div>
    <div id="invoiceModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background-color: rgba(0,0,0,0.7); z-index:1000; justify-content:center; align-items:center;">
        <div style="position:relative; background:#fff; padding:20px; border-radius:8px; max-width:90%; max-height:90%;">
            <span onclick="closeModal()"
                style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:50px;">&times;</span>
            <img id="invoiceImage" src="" alt="Invoice"
                style="max-width:100%; max-height:80vh; display:block; margin:auto;">
        </div>
    </div>
    <div id="custom-alert" class="alert d-none" role="alert"></div>


    @push('scripts')
        <script src="{{ asset('assets/js/admin/categories.js') }}"></script>
    @endpush

@endsection
