 {{-- @push('styles')
     <link rel="stylesheet" href="{{ asset('assets/css/recent-search.css') }}">
 @endpush

 <section class="recent-card-category recent-home-style" id="recentSearches">
     <div class="recent-searches-card">
         <div class="recent-searches-header">
             <h2 class="recent-searches-title">Recent Searches</h2>
             <p class="recent-searches-description">
                 Your latest price comparisons and saved searches
             </p>
         </div>
         <div class="recent-searches-content">
             <div class="recent-searches-grid">
                 @foreach ($recentSearches as $search)
                     <div class="recent-search-item">
                         <div class="recent-search-icon-wrapper">
                             {{-- Optional: Render a dynamic icon or use a default --
                             <svg class="recent-search-icon" xmlns="http://www.w3.org/2000/svg" ...>
                                 <path d="..." />
                             </svg>
                         </div>
                         <div class="recent-search-info">
                             <h3 class="recent-search-title">{{ $search->product_name }}</h3>
                             <p class="recent-search-description">Searched {{ $search->created_at->diffForHumans() }}
                             </p>
                             <div class="recent-search-meta">
                                 <span class="recent-search-best-price">Best:
                                     ${{ number_format($search->best_price, 2) }}</span>
                             </div>
                         </div>
                         <button class="recent-search-action">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" ...>
                                 <path d="M5 12h14"></path>
                                 <path d="m12 5 7 7-7 7"></path>
                             </svg>
                         </button>
                     </div>
                 @endforeach


             </div>
         </div>
     </div>
 </section> --}}
