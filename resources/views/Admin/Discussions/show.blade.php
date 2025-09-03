@extends('Admin.Layouts.app')

@section('title', 'Show Discussion')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/discussion-show.css') }}">
@endpush

@section('page-content')
    <div class="admin-container">
        <!-- Header Section -->
        <div class="admin-page-header">
            <div class="header-left">
                <a href="{{ route('admin.discussions.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Back to Discussions
                </a>
                <h1 class="page-title">Discussion Details</h1>
            </div>
            <div class="header-actions">
                <button class="btn btn-lock btn-sm"
                    onclick="toggleLockDiscussion({{ $discussion->id }}, {{ $discussion->locked ? 'true' : 'false' }})">
                    <i class="fas {{ $discussion->locked ? 'fa-lock' : 'fa-unlock' }}"></i>
                    {{ $discussion->locked ? 'Unlock' : 'Lock' }} Discussion
                </button>

                <button class="btn btn-danger btn-sm" onclick="deleteDiscussion({{ $discussion->id }})">
                    <i class="fas fa-trash"></i>
                    Delete Discussion
                </button>
            </div>
        </div>

        <!-- Discussion Content -->
        <div class="admin-card">
            <div class="card-header">
                <div class="discussion-header">
                    <div class="discussion-meta">
                        <span class="discussion-category">{{ $discussion->category->name ?? 'Uncategorized' }}</span>
                        <span class="discussion-status {{ $discussion->locked ? 'locked' : 'unlocked' }}">
                            <i class="fas {{ $discussion->locked ? 'fa-lock' : 'fa-unlock' }}"></i>
                            {{ $discussion->locked ? 'Locked' : 'Unlocked' }}
                        </span>
                    </div>
                    <h2 class="discussion-title">{{ $discussion->title }}</h2>
                    <div class="discussion-info">
                        <span class="author">Started by <strong>{{ $discussion->author->first_name }}
                                {{ $discussion->author->last_name }}</strong></span>
                        <span class="date">{{ $discussion->created_at->format('F j, Y') }}</span>
                        <span class="replies">{{ $discussion->replies->count() }} replies</span>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <!-- Original Post -->
                <div class="post original-post">
                    <div class="post-header">
                        <div class="user-info">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-details">
                                <span class="username">{{ $discussion->author->first_name }}
                                    {{ $discussion->author->last_name }}</span>
                                <span class="post-date">{{ $discussion->created_at->format('F j, Y \a\t h:i A') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="post-content">
                        <p>{{ $discussion->content }}</p>
                    </div>
                </div>

                <!-- Replies Section -->
                <div class="replies-section">
                    <h3 class="section-title">Replies ({{ $discussion->replies->count() }})</h3>

                    @foreach ($discussion->replies as $reply)
                        <div class="post reply" data-id="{{ $reply->id }}">
                            <div class="post-header">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="user-details">
                                        <span class="username">{{ $reply->author->first_name }}
                                            {{ $reply->author->last_name }}</span>
                                        <span
                                            class="post-date">{{ $reply->created_at->format('F j, Y \a\t h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="post-actions">
                                    <button class="btn-icon danger" onclick="deletePost({{ $reply->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="post-content">
                                <p>{{ $reply->content }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div id="custom-alert" class="alert d-none" role="alert"></div>

    @push('scripts')
        <script src="{{ asset('assets/js/admin/discussions.js') }}"></script>
    @endpush
@endsection
