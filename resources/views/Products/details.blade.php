<x-base-layout title="Product Details">

@push('styles')
<link href="{{ asset('assets/css/details.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/rating.css') }}" rel="stylesheet">
@endpush

<div class="product-details-page">
    <main class="main">
        <div class="container">
            <!-- Back Navigation -->
            <div class="back-nav">
                <a href="{{ route('products.show') }}" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Back to Products
                </a>
            </div>

            <!-- Product Header -->
            <div class="product-header">
                <div class="product-image-section">
                    <div class="product-image">
                        <img id="product-image" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                </div>

                <div class="product-info-section">
                    <div class="product-title-area">
                        <div class="title-and-badge">
                            <div>
                                <h1 id="product-name" class="product-title">{{ $product->name }}</h1>
                            </div>
                            <span id="product-category" class="category-badge">{{ $product->category->name }}</span>
                        </div>

                        <div class="rating-info">
                            <div class="rating">
                                <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                                </svg>
                                <span id="product-rating" class="rating-value">{{ $averageRating }}</span>
                            </div>
                            <div id="price-count" class="price-reports">
                                Based on {{ $ratingsCount }} rating{{ $ratingsCount > 1 ? 's' : '' }} reports
                            </div>
                        </div>
                    </div>

                    <div class="pricing-section">
                        <div class="price-range">
                            <h3 class="section-title">Price Range</h3>
                            <div id="price-count" class="price-reports">
                                Based on {{ $priceCount }} price{{ $priceCount > 1 ? 's' : '' }} reports
                            </div>
                            <div class="price-range-display">
                                <div class="lowest-price">
                                    <div class="price-label">Lowest Price</div>
                                    <div id="lowest-price" class="price-value lowest">${{ $minPrice }}</div>
                                </div>
                                <div class="highest-price">
                                    <div class="price-label">Highest Price</div>
                                    <div id="highest-price" class="price-value highest">${{ $maxPrice }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="average-price-section">
                            <h3 class="section-title">Average Price</h3>
                            <div id="average-price" class="average-price">${{ $avgPrice }}</div>
                            <div id="last-updated" class="last-updated">Last Updated {{ $updatedAt }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="other-listings-section">
        <div class="other-listings-container">
            <div class="listings-section-header">
                <h2 class="listings-section-title">Other listings for "{{ $product->name }}"</h2>
                <p class="listings-section-description">Compare prices and ratings from different sellers</p>
            </div>

            @php
                $otherListings = $relatedProducts->where('id');
            @endphp

            @if($otherListings->count() > 0)
                <div class="listings-grid">
                    @foreach ($otherListings as $related)
                        <a href="{{ route('products.details', $related->id) }}" class="listing-card">
                            <div class="listing-image">
                                <img src="{{ asset($related->image_path) }}"
                                     alt="{{ $related->name }}"
                                     loading="lazy"
                                     class="listing-product-image" />
                            </div>

                            <div class="listing-content">
                                <h3 class="listing-product-name">{{ $related->name }}</h3>

                                @if ($related->verified)
                                    <span class="verified-badge">Verified</span>
                                @else
                                    <span class="not-verified-badge">Not Verified</span>
                                @endif

                                <div class="listing-price-section">
                                    <div class="listing-price">${{ $related->price }}</div>
                                    <div class="listing-reports">1 report</div>
                                </div>

                                <div class="listing-stores-info">
                                    <span class="listing-stores-text">Store: {{ $related->store_name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="no-listings">
                    <svg class="no-listings-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <circle cx="12" cy="16" r="1"></circle>
                    </svg>
                    <div class="no-listings-title">No other listings found</div>
                    <div class="no-listings-description">Only one store has reported this product.</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Ratings and Reviews -->
    <div class="user-rating-section">
        <div class="rating-header">
            <h3 class="rating-section-title">Rate This Product</h3>
            <p class="rating-section-description">Share your experience with this product to help other customers</p>
        </div>

        <!-- Display success/error messages -->
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    showNotification(@json(session('success')), 'success');
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    showNotification(@json(session('error')), 'error');
                });
            </script>
        @endif

        <form class="rating-form" id="rating-form" method="POST" action="{{ route('products.rate',$product->name) }}">
            @csrf
            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}" />

            <div class="rating-input-group">
                <label class="rating-label">Your Rating</label>
                <div class="star-rating" id="star-rating">
                    <svg class="star" data-rating="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                    </svg>
                    <svg class="star" data-rating="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                    </svg>
                    <svg class="star" data-rating="3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                    </svg>
                    <svg class="star" data-rating="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                    </svg>
                    <svg class="star" data-rating="5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                    </svg>
                </div>
                <div class="rating-value-display" id="rating-value-display">Click stars to rate</div>
                @error('rating')
                    <div class="error">
                        <div class="error__title">{{ $message }}</div>
                    </div>
                @enderror
            </div>

            <div class="rating-input-group">
                <label for="rating-comment" class="rating-label">Your Review (Optional)</label>
                <textarea
                    name="comment"
                    id="rating-comment"
                    class="rating-textarea"
                    placeholder="Share your thoughts about this product..."
                    maxlength="500"
                >{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="error">
                        <div class="error__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24"
                                height="24" fill="none">
                                <path fill="#393a37"
                                    d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z">
                                </path>
                            </svg>
                        </div>
                        <div class="error__title">{{ $message }}</div>
                    </div>
                @enderror
            </div>

            <div class="rating-actions">
                <button type="submit" class="submit-rating-btn" id="submit-rating-btn">
                    Submit Rating
                </button>
                <button type="button" class="cancel-rating-btn" id="cancel-rating-btn">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- User Reviews Section -->
    <div class="user-reviews-section">
        <div class="reviews-header">
            <h3 class="reviews-title">Customer Reviews</h3>
            <div class="reviews-count" id="reviews-count">{{ $ratings->count() }} reviews</div>
        </div>

        <div class="reviews-list" id="reviews-list">
            @forelse($ratings as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="review-star {{ $i <= $review->rating ? 'filled' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                </svg>
                            @endfor
                        </div>
                        <small>{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    @if($review->comment)
                        <p>{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p>No reviews yet for this product.</p>
            @endforelse
        </div>
    </div>
</div>

<div>                  </div>

@if(session('restore_rating'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingData = @json(session('restore_rating'));

    // Restore the rating value
    if (ratingData.rating) {
        const ratingInput = document.querySelector('input[name="rating"][value="' + ratingData.rating + '"]');
        if (ratingInput) {
            ratingInput.checked = true;
        }

        // If you're using star ratings, you might need to trigger visual updates
        // For example, if you have a function to update star display:
        // updateStarDisplay(ratingData.rating);
    }

    // Restore the comment
    if (ratingData.comment) {
        const commentTextarea = document.querySelector('textarea[name="comment"]');
        if (commentTextarea) {
            commentTextarea.value = ratingData.comment;
        }
    }

    // Optionally scroll to the rating form
    const ratingForm = document.querySelector('form[action*="rate"]');
    if (ratingForm) {
        ratingForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
@endif

<script>


// Star Rating System - Clean Implementation (Server-side validation only)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Star Rating System Initialized');

    // Get all necessary elements
    const stars = document.querySelectorAll('.star');
    const ratingValueDisplay = document.getElementById('rating-value-display');
    const submitBtn = document.getElementById('submit-rating-btn');
    const cancelBtn = document.getElementById('cancel-rating-btn');
    const ratingInput = document.getElementById('rating-input');
    const ratingForm = document.getElementById('rating-form');
    const commentField = document.getElementById('rating-comment');

    // Check if all elements exist
    if (!stars.length || !ratingValueDisplay || !ratingInput || !ratingForm) {
        console.error('Required rating elements not found');
        return;
    }

    // Rating state
    let currentRating = parseInt(ratingInput.value) || 0;
    let hoveredRating = 0;

    // Rating descriptions
    const ratingDescriptions = {
        1: 'Poor',
        2: 'Fair',
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };

    // Initialize display
    updateStarDisplay(currentRating);
    updateRatingDisplay(currentRating);

    // Add event listeners to stars
    stars.forEach((star, index) => {
        const rating = index + 1;
        star.dataset.rating = rating;

        // Mouse enter - show preview
        star.addEventListener('mouseenter', function() {
            hoveredRating = rating;
            updateStarDisplay(hoveredRating);
            updateRatingDisplay(hoveredRating);
        });

        // Mouse leave - revert to current rating
        star.addEventListener('mouseleave', function() {
            hoveredRating = 0;
            updateStarDisplay(currentRating);
            updateRatingDisplay(currentRating);
        });

        // Click - set rating
        star.addEventListener('click', function(e) {
            e.preventDefault();
            currentRating = rating;
            updateStarDisplay(currentRating);
            updateRatingDisplay(currentRating);
            ratingInput.value = currentRating;
            console.log('Rating set to:', currentRating);
        });
    });

    // Update star visual display
    function updateStarDisplay(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.fill = '#ffd700';
                star.style.stroke = '#ffd700';
            } else {
                star.style.fill = 'none';
                star.style.stroke = 'currentColor';
            }
        });
    }

    // Update rating text display
    function updateRatingDisplay(rating) {
        if (rating === 0) {
            ratingValueDisplay.textContent = 'Click stars to rate';
            ratingValueDisplay.style.color = '#666';
        } else {
            ratingValueDisplay.textContent = `${rating} star${rating !== 1 ? 's' : ''} - ${ratingDescriptions[rating]}`;
            ratingValueDisplay.style.color = '#333';
        }
    }

    // Cancel button functionality
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            resetForm();
        });
    }

    // Reset form to initial state
    function resetForm() {
        currentRating = 0;
        hoveredRating = 0;
        updateStarDisplay(0);
        updateRatingDisplay(0);
        ratingInput.value = '';
        if (commentField) {
            commentField.value = '';
        }
    }

    // Form submission handler - NO CLIENT-SIDE VALIDATION
    ratingForm.addEventListener('submit', function(e) {
        // Just ensure the hidden input has the correct value before submission
        ratingInput.value = currentRating;

        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
        }

        console.log('Form submitting with rating:', currentRating);
        console.log('Hidden input value:', ratingInput.value);

        // Let the server handle all validation - no client-side validation
        return true;
    });

    // Add CSS for better visual feedback
    const style = document.createElement('style');
    style.textContent = `
        .star {
            cursor: pointer;
            transition: all 0.2s ease;
            width: 24px;
            height: 24px;
        }

        .star:hover {
            transform: scale(1.1);
        }

        .star-rating {
            display: flex;
            gap: 4px;
            margin: 8px 0;
        }

        .rating-value-display {
            font-size: 14px;
            margin-top: 8px;
            min-height: 20px;
        }

        .submit-rating-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    `;
    document.head.appendChild(style);

    console.log('Star Rating System Ready');
});
</script>

</x-base-layout>
