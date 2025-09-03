@extends('Admin.Layouts.app')

@section('title', 'Review Details')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/ratings-view.css') }}">
@endpush

@section('page-content')
<div class="admin-layout">
    <main class="admin-content">
        <div class="container">

            <!-- Page Header -->
            <div class="page-header">
                <div class="header-left">
                    <h1>Review Details</h1>
                    <div class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <i class="fas fa-chevron-right"></i>
                        <a href="{{ route('admin.reviews.index') }}">Reviews & Ratings</a>
                        <i class="fas fa-chevron-right"></i>
                        <span>Review #{{ str_pad($rating->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Reviews
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $rating->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                            Delete Review
                        </button>
                    </form>
                </div>
            </div>

            <!-- Review Details Section -->
            <div class="review-details-section">
                <div class="review-header">
                    <div class="review-meta">
                        <div class="meta-group">
                            <div class="meta-item">
                                <span class="meta-label">Review ID:</span>
                                <span class="meta-value">#{{ str_pad($rating->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>

                            <div class="meta-item">
                                <span class="meta-label">Reviewer:</span>
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        {{ strtoupper(substr($rating->user->first_name ?? 'G', 0, 1)) }}
                                        {{ strtoupper(substr($rating->user->last_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="reviewer-details">
                                        <div class="reviewer-name">
                                            {{ $rating->user->first_name ?? 'Guest' }} {{ $rating->user->last_name ?? '' }}
                                        </div>
                                        @if ($rating->user)
                                            <div class="reviewer-email">{{ $rating->user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="meta-item">
                                <span class="meta-label">Rating:</span>
                                <div class="rating-display">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $rating->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="rating-number">{{ number_format($rating->rating, 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="meta-group">
                            <div class="meta-item">
                                <span class="meta-label">Date:</span>
                                <span class="meta-value">{{ $rating->created_at->format('F d, Y') }}</span>
                            </div>

                            <div class="meta-item">
                                <span class="meta-label">Product:</span>
                                <div class="product-info">
                                    <img src="{{ asset($rating->product->image_path ?? 'assets/images/no-image.png') }}"
                                        alt="Product" class="product-image">
                                    <div class="product-details">
                                        <div class="product-name">{{ $rating->product->name ?? 'Unknown Product' }}</div>
                                        <div class="product-category">{{ $rating->product->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Review Comment -->
                <div class="review-content">
                    <div class="content-section">
                        <div class="section-title">
                            <i class="fas fa-comment-alt"></i>
                            Review Comment
                        </div>
                        <div class="review-text">
                            {{ $rating->comment ?? 'No comment provided.' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection
