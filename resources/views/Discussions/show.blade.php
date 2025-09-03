<x-base-layout title='Show Discussion'>
    @push('styles')
        <link href="{{ asset('assets/css/viewDiscussion.css') }}" rel="stylesheet">
    @endpush
    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="back-button">
                <a href="/discussions" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Discussions
                </a>
            </div>

            <!-- Main Discussion -->
            <div class="discussion-main">
                <div class="discussion-header">
                    <div class="discussion-meta">
                        <span class="category-badge">{{ $discussion->category->name }}</span>
                        <span class="discussion-info">
                            by {{ $discussion->author->first_name }} {{ $discussion->author->last_name }} on
                            {{ $discussion->created_at }}
                        </span>
                    </div>
                    <h1 class="discussion-title">{{ $discussion->topic }}</h1>
                </div>
                <div class="discussion-content">
                    <p class="discussion-text">
                        {{ $discussion->content }}
                    </p>
                    <div class="discussion-actions">
                        <button class="like-btn" data-discussion-id="{{ $discussion->id }}"
                            onclick="toggleDiscussionLike(this)">
                            <i class="fas fa-thumbs-up"></i>
                            <span class="like-count">{{ $discussion->likes->count() }}</span> Likes
                        </button>

                        <div class="reply-count">
                            <i class="fas fa-comment"></i>
                            <span>{{ $discussion->replies->count() }} Replies</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies Section -->
            <div class="replies-section">
                <h2 class="replies-title">Replies ({{ $discussion->replies->count() }})</h2>
                @foreach ($discussion->replies as $index => $reply)
                    <div class="reply-item">
                        <div class="reply-header">
                            <span class="reply-author">{{ $reply->author->first_name }}
                                {{ $reply->author->last_name }}</span>
                            <span class="reply-date">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="reply-content">
                            {{ $reply->content }}
                        </p>
                        <div class="reply-actions">
                            <button class="like-btn small" data-reply-id="{{ $reply->id }}"
                                onclick="toggleReplyLike(this)">
                                <i class="fas fa-thumbs-up"></i>
                                <span class="like-count">{{ $reply->likes->count() }}</span>
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>

            @if (!$discussion->locked)
            <!-- Reply Form -->
            <div class="reply-form-container">
                <div class="reply-form-header">
                    <h3>Add Your Reply</h3>
                </div>
                <div class="reply-form-content">
                    <form id="replyForm" class="reply-form" method="POST"
                        action="{{ route('replies.store', $discussion->id) }}">
                        @csrf
                        <textarea id="replyContent" name="content" placeholder="Share your thoughts or provide helpful information..."
                            class="reply-textarea"></textarea>
                        @error('content')
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
                                <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        viewBox="0 0 20 20" height="20">
                                        <path fill="#393a37"
                                            d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z">
                                        </path>
                                    </svg></div>
                            </div>
                        @enderror
                        <div class="reply-form-actions">
                            <button type="submit" class="submit-reply-btn">
                                <i class="fas fa-paper-plane"></i>
                                Post Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </main>
    @if (session('success'))
        <script>
            showNotification(@json(session('success')), 'success');
        </script>
    @endif

    @if (session('error'))
        <script>
            showNotification(@json(session('error')), 'error');
        </script>
    @endif

</x-base-layout>

<script>
    async function toggleDiscussionLike(button) {
        const discussionId = button.getAttribute('data-discussion-id');

        const response = await fetch(`/discussions/${discussionId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
        });

        const data = await response.json();

        if (response.ok) {
            const likeCountSpan = button.querySelector('.like-count');
            likeCountSpan.textContent = data.likesCount;

            // Toggle liked color
            if (data.liked) {
                button.classList.add('liked');
                button.style.color = '#ea580c';
            } else {
                button.classList.remove('liked');
                button.style.color = '';
            }
        } else {
            alert('Error liking discussion.');
        }
    }

    async function toggleReplyLike(button) {
        const replyId = button.getAttribute('data-reply-id');

        const response = await fetch(`/replies/${replyId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
        });

        const data = await response.json();

        if (response.ok) {
            const likeCountSpan = button.querySelector('.like-count');
            likeCountSpan.textContent = data.likesCount;

            if (data.liked) {
                button.classList.add('liked');
                button.style.color = '#ea580c';
            } else {
                button.classList.remove('liked');
                button.style.color = '';
            }
        } else {
            alert('Error liking reply.');
        }
    }

    function likeDiscussion() {
        const likeBtn = document.querySelector('.discussion-actions .like-btn');
        const likeCount = likeBtn.querySelector('.like-count');
        let count = parseInt(likeCount.textContent);
        likeCount.textContent = count + 1;
        likeBtn.style.color = '#ea580c';
    }

    function likeReply(replyIndex) {
        const replyItem = document.querySelectorAll('.reply-item')[replyIndex - 1];
        const likeBtn = replyItem.querySelector('.like-btn');
        const likeCount = likeBtn.querySelector('.like-count');
        let count = parseInt(likeCount.textContent);
        likeCount.textContent = count + 1;
        likeBtn.style.color = '#ea580c';
    }
</script>
