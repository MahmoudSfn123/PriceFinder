@props(['category', 'products', 'searchQuery'=>'', 'searchResults'=>collect()])

<x-base-layout>
    <div class="community-price-search-section" >
        <div class="card" style="scroll-margin-top:100px;">
            <div class="card-header" >
                <h3 class="card-title" >
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    Community Price Search
                </h3>
                <p class="card-description">
                    Search for products and see real prices uploaded by our community
                </p>
            </div>
            <div class="card-content">
                <!-- Search Input -->
                <div class="search-container">
                    <form action="{{ route('home.index') }}#search-component" method="GET" class="search-form">
                        <input type="text" name="search" id="product-search-input" class="search-input"
                            value="{{ request('search') }}"
                            placeholder="Search for a product (e.g., iPhone 13 Pro Max, Sony headphones...)" />
                        <button id="search-button" class="search-button">Search</button>
                    </form>
                </div>

                <!-- Loading State -->
                <div id="loading-state" class="loading-state hidden">
                    <div class="spinner"></div>
                    <p>Searching community prices...</p>
                </div>

                @if (empty($searchQuery))
                    <!-- Initial State -->
                    <div id="initial-state" class="initial-state">
                        <svg class="large-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <h3>Search Community Prices</h3>
                        <p>Enter a product name to see prices uploaded by our community members</p>
                    </div>
                @elseif($searchResults->count() > 0)
                    <!-- Search Results -->
                    <div id="search-results" class="search-results ">
                        <div class="results-summary">
                            <h3>Found {{ $searchResults->count() }} price{{ $searchResults->count() !== 1 ? 's' : '' }}
                                for
                                "{{ $searchQuery }}"</h3>
                            @php
                                $bestPrice = $searchResults->min('price');
                            @endphp
                            <p class="best-price-text">Best price: ${{ $bestPrice }}</p>
                        </div>
                        <div class="results-list">
                            @foreach ($searchResults as $result)
                                @php
                                    $isBestPrice = $result->price == $bestPrice;
                                    $formattedDate = $result->purchase_date;
                                @endphp
                                <div class="price-result {{ $isBestPrice ? 'best-price' : '' }}">
                                    <div class="result-header">
                                        <div class="result-info">
                                            <div class="result-title">
                                                <h4>{{ $result->name }}</h4>
                                                @if ($isBestPrice)
                                                    <span class="badge best-price">Best Price</span>
                                                @endif
                                                @if ($result->verified)
                                                    <span class="badge verified">Verified</span>
                                                @endif
                                            </div>
                                            <div class="result-details">
                                                <div class="detail-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                                        <circle cx="12" cy="10" r="3"></circle>
                                                    </svg>
                                                    <span>{{ $result->store_name }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M8 2v4"></path>
                                                        <path d="M16 2v4"></path>
                                                        <rect width="18" height="18" x="3" y="4" rx="2">
                                                        </rect>
                                                        <path d="M3 10h18"></path>
                                                    </svg>
                                                    <span>{{ $formattedDate }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="12" cy="7" r="4"></circle>
                                                    </svg>
                                                    @if ($result->users->isNotEmpty())

                                                            <span>Uploaded by {{ $result->users[0]->first_name }} {{$result->users[0]->last_name}}</span>

                                                    @else
                                                        <span>Uploader unknown</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="result-price">
                                            <div class="price-amount"> ${{ $result->price }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @else
                    <!-- No Results State -->
                    <div id="no-results-state" class="no-results-state">
                        <svg class="large-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <h3>No prices found</h3>
                        <p id="no-results-text">No community members have uploaded prices for this product yet.</p>
                    </div>
                @endif
            </div>
        </div>
</x-base-layout>
