<x-app-layout title='Products Page'>


    <x-slot:firstpage>
        <div class="breadcrumb-section breadcrumb-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="breadcrumb-text">
                            <p>See more Details</p>
                            <h1 style="margin-bottom:20px !important"> {{ $category }} </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:firstpage>

    <!-- Header -->
    {{-- <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">
                    <svg class="logo-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5H2l2 7h5m0 0l5 5 5-5m-5 5v7"></path>
                    </svg>
                    <h1 class="logo-text">PriceFinder</h1>
                </a>
                <nav class="nav">
                    <a href="/products" class="nav-button active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <span>Products</span>
                    </a>
                    <div class="dropdown">
                        <button class="nav-button dropdown-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                            <span>Categories</span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-label">Browse Categories</div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Electronics</a>
                            <a href="#" class="dropdown-item">Clothing</a>
                            <a href="#" class="dropdown-item">Home & Kitchen</a>
                            <a href="#" class="dropdown-item">Beauty & Personal Care</a>
                            <a href="#" class="dropdown-item">Books</a>
                            <a href="#" class="dropdown-item">Toys & Games</a>
                            <a href="#" class="dropdown-item">Sports & Outdoors</a>
                            <a href="#" class="dropdown-item">Grocery</a>
                            <a href="#" class="dropdown-item">Automotive</a>
                        </div>
                    </div>
                    <button class="nav-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10,9 9,9 8,9"></polyline>
                        </svg>
                        <span>How it works</span>
                    </button>
                    <button class="nav-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10,9 9,9 8,9"></polyline>
                        </svg>
                        <span>History</span>
                    </button>
                    <button class="cta-button">Get Started</button>
                </nav>
            </div>
        </div>
    </header> --}}

    <!-- Main Content -->
    {{-- < class="main">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Products</h1>
                <p class="page-description">Browse products with community pricing data</p>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-section">
                <div class="search-container">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input type="text" id="search-input" class="search-input" placeholder="Search products or brands...">
                </div>

                <div class="filter-section">
                    <svg class="filter-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22,3 2,3 10,12.46 10,19 14,21 14,12.46"></polygon>
                    </svg>
                    <div class="category-filters">
                        <button class="filter-button active" data-category="All">All</button>
                        <button class="filter-button" data-category="Electronics">Electronics</button>
                        <button class="filter-button" data-category="Footwear">Footwear</button>
                        <button class="filter-button" data-category="Home & Kitchen">Home & Kitchen</button>
                        <button class="filter-button" data-category="Clothing">Clothing</button>
                        <button class="filter-button" data-category="Beauty">Beauty</button>
                    </div>
                </div>
            </div> --}}

    <!-- Products Grid -->
    <div class="product-section mt-150 mb-150">
        @if ($product->count())
            <div class="products-grid" id="products-grid">
                @foreach ($product as $item)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset($item->image_path) }}" loading="lazy" alt="{{ $item->name }}">
                        </div>

                        <div class="product-header">
                            <div class="product-title-section">
                                <div>
                                    <div class="product-title">{{ $item->name }}</div>

                                </div>
                                <div class="category-badge">{{ $item->category->name }}</div>
                            </div>
                        </div>

                        <div class="product-content">

                            <div class="price-info">
                                <div class="price-section">
                                    <div class="average-price">${{ number_format($item->avg_price, 2) }}</div>
                                    <div class="price-count">Average from {{ $item->price_count }}
                                        price{{ $item->price_count == 1 ? '' : 's' }}
                                    </div>
                                </div>
                                <div class="rating-section">
                                    <svg class="star-icon" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polygon
                                            points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26">
                                        </polygon>
                                    </svg>
                                    <span class="rating-value">{{ $item->avg_rating }}</span>
                                </div>
                            </div>

                            <div class="stores-section">
                                <div class="stores-label">Available at:</div>
                                <div class="stores-list">
                                    @foreach ($item->stores->take(3) as $store )
                                     <span class="store-badge">{{$store}}</span>
                                    @endforeach
                                    @if ($item->stores->count()>3)
                                     <span class="store-badge">+{{$item->stores->count() - 3}} more</span>
                                    @endif


                                </div>

                            </div>


                            <div class="last-updated">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="16" y1="2" x2="16" y2="6">
                                    </line>
                                    <line x1="8" y1="2" x2="8" y2="6">
                                    </line>
                                    <line x1="3" y1="10" x2="21" y2="10">
                                    </line>
                                </svg>
                                <span>Updated {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</span>
                            </div>

                            <a href="/products/details/{{ $item->id }}" class="view-details-button">View Price Details</a>
                        </div>
                    </div>
                @endforeach
       </div>
    @else
        <div class="no-results" id="no-results">
            <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <h3 class="no-results-title">No products found</h3>
            <p class="no-results-description">Try adjusting your search or filter criteria</p>
        </div>
        @endif

    </div>


    <style>
        /* Reset and Base Styles */
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles
        .header {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: inherit;
        }

        .logo-icon {
            color: #6366f1;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
            text-decoration: none;
        }

        .nav-button:hover {
            background-color: #f3f4f6;
        }

        .nav-button.active {
            background-color: #6366f1;
            color: white;
        }

        .cta-button {
            background-color: #6366f1;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .cta-button:hover {
            background-color: #4f46e5;
        }

        /* Dropdown Styles
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 50;
            width: 12rem;
            margin-top: 0.5rem;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-label {
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6b7280;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e5e7eb;
        }

        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        /* Main Content
        .main {
            padding: 2rem 0;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #6b7280;
        }
        /* Search and Filter
        .search-filter-section {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .search-container {
            position: relative;
            flex: 1;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-input {
            width: 100%;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .filter-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-icon {
            color: #6b7280;
        }

        .category-filters {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-button {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-button:hover {
            background-color: #f3f4f6;
        }

        .filter-button.active {
            background-color: #6366f1;
            color: white;
            border-color: #6366f1;
        } */

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 3rem;
            margin-left: 65px;
            margin-right: 65px;
        }

        .product-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.2s;
            max-width: 1500px;
            max-height: 2000px;
        }

        .product-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            aspect-ratio: 1;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-header {
            padding: 1.5rem 1.5rem 0.5rem;
        }

        .product-title-section {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .product-title {
            font-size: 1.3rem;
            font-weight: 500;
            line-height: 1.4;
            margin-bottom: 0.25rem;
        }

        .product-brand {
            color: #6b7280;
            font-weight: 500;
        }

        .category-badge {
            background-color: #f3f4f6;
            color: #051922;
            font-size: 0.75rem;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-weight:500;
        }

        .product-content {
            padding: 0 1.5rem 1.5rem;
        }

        .price-info {

            margin-bottom: 0.75rem;
        }


        .average-price {
            font-size: 2rem;
            font-weight: bold;
            color: #F28123;
        }

        .price-count {
            font-size: 1rem;
            color: #6b7280;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .star-icon {
            color: #fbbf24;
            fill: currentColor;
        }

        .rating-value {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stores-section {
            margin-bottom: 0.75rem;
        }

        .stores-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .stores-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .store-badge {
            background-color: white;
            border: 1px solid #d1d5db;
            color: #051922;
            font-size: 0.86rem;
            padding: 0.125rem 0.5rem;
            border-radius: 0.75rem;
            font-weight: 650;
        }

        .last-updated {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .view-details-button {
            display:block;
            width: 100% ;
            background-color: #F28123;
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
        }

        .view-details-button:hover {
            background-color: #051922;
            color: #F28123;
            border: none;
        }





        /* No Results */
        .no-results {
            text-align: center;
            padding: 3rem 0;
            width: 100%;
        }

        .no-results-icon {
            color: #d1d5db;
            margin: 0 auto 1rem;
        }

        .no-results-title {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .no-results-description {
            color: #6b7280;
        }

        .hidden {
            display: none;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .search-filter-section {
                flex-direction: row;
                align-items: center;
            }

            .search-container {
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .nav {
                justify-content: space-between;
                overflow-x: auto;
            }

            .nav-button span {
                display: none;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 0.5rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</x-app-layout>
