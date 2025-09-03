@extends('Admin.Layouts.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/ratings.css') }}">
@endpush

@section('page-content')
    <div class="reviews-ratings-admin-section">
        <div class="reviews-section-header">
            <div>
                <h3>Reviews & Ratings Management</h3>
                <div class="reviews-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $totalReviews }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $avgRating }}</div>
                        <div class="stat-label">Avg Rating</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $thisMonth }}</div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="reviews-content">

            <!-- Reviews Table -->
            <div class="reviews-table">
                <div class="reviews-table-header">
                    <span>ID</span>
                    <span>Reviewer</span>
                    <span>Rating</span>
                    <span>Product</span>
                    <span>Review</span>
                    <span>Date</span>
                    <span>Actions</span>
                </div>

                @forelse ($ratings as $rating)
                    <div class="reviews-table-row">
                        <span class="review-id">#{{ str_pad($rating->id, 3, '0', STR_PAD_LEFT) }}</span>
                        <span class="reviewer-info">
                            <div class="reviewer-avatar">
                                @if ($rating->user && $rating->user->first_name && $rating->user->last_name)
                                    {{ strtoupper(substr($rating->user->first_name, 0, 1)) }}{{ strtoupper(substr($rating->user->last_name, 0, 1)) }}
                                @else
                                    G
                                @endif
                            </div>
                            <div class="reviewer-details">
                                <div class="reviewer-name">
                                    @if ($rating->user && ($rating->user->first_name || $rating->user->last_name))
                                        {{ $rating->user->first_name ?? '' }} {{ $rating->user->last_name ?? '' }}
                                    @else
                                        Guest
                                    @endif
                                </div>
                            </div>
                        </span>
                        <span class="review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor

                        </span>
                        <span class="product-info" style="align-items: center">
                            <img src="{{ asset($rating->product->image_path) }}" alt="Product" class="product-image">
                            <div class="product-details">
                                <span class="product-name">{{ $rating->product_name }}</span>
                            </div>
                        </span>
                        <span class="review-text">
                            {{ Str::limit($rating->comment ?? 'No comment.', 150) }}
                        </span>
                        <span class="review-date">{{ $rating->created_at->format('M d, Y') }}</span>
                        <span class="actions-dropdown">
                            <button class="actions-trigger" onclick="toggleDropdown(this)">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view" href="{{ route('admin.reviews.show',$rating->id) }}">
                                    <i class="fas fa-eye"></i> View Full
                                </a>
                                <div class="dropdown-separator"></div>
                                <form action="{{ route('admin.reviews.destroy', $rating->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item delete">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </span>
                    </div>
                @empty
                    <div class="reviews-table-row">
                        <span colspan="7">No reviews found.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-container" data-current-page="{{ $ratings->currentPage() }}"
            data-last-page="{{ $ratings->lastPage() }}">
            <div class="pagination">
                <button class="pagination-btn prev"
                    @if (!$ratings->onFirstPage()) data-url="{{ $ratings->previousPageUrl() ? $ratings->previousPageUrl() . '#store-entries' : '' }}" @else disabled @endif>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>

                <div class="pagination-numbers">
                    @for ($i = 1; $i <= $ratings->lastPage(); $i++)
                        <button class="page-number {{ $i == $ratings->currentPage() ? 'active' : '' }}"
                            data-url="{{ $ratings->url($i) . '#store-entries' }}">
                            {{ $i }}
                        </button>
                    @endfor
                </div>

                <button class="pagination-btn next"
                    @if ($ratings->hasMorePages()) data-url="{{ $ratings->hasMorePages() ? $ratings->nextPageUrl() . '#store-entries' : '' }}" @else disabled @endif>
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.querySelector(".pagination");

            if (container) {
                container.addEventListener("click", function(e) {
                    const target = e.target.closest("button[data-url]");
                    if (target && !target.disabled) {
                        const url = target.getAttribute("data-url");
                        if (url) {
                            window.location.href = url;
                        }
                    }
                });

            }
        });

        function toggleDropdown(button) {
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== button.nextElementSibling) {
                    menu.classList.remove('show');
                }
            });

            // Toggle current dropdown
            const menu = button.nextElementSibling;
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.actions-dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Handle dropdown actions
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                const action = this.classList.contains('view') ? 'view' :
                    this.classList.contains('approve') ? 'approve' :
                    this.classList.contains('reject') ? 'reject' : 'delete';

                console.log(`Action: ${action}`);

                // Close dropdown
                this.closest('.dropdown-menu').classList.remove('show');

                // Add your action logic here
            });
        });

        // Handle filter changes
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                console.log(`Filter changed: ${this.value}`);
                // Add your filter logic here
            });
        });

        // Handle search
        document.querySelector('.search-input').addEventListener('input', function() {
            console.log(`Search: ${this.value}`);
            // Add your search logic here
        });
    </script>
@endpush
