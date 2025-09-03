<x-app-layout title='Start Conversation'>

    @push('styles')
     <link href="{{ asset('assets/css/startDiscussion.css') }}" rel="stylesheet">
    @endpush
    <x-slot:firstpage>
        <div class="breadcrumb-section breadcrumb-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="breadcrumb-text">
                            <p>Share your thoughts. Ask anything.</p>
                            <h1>Start Conversation</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:firstpage>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="back-button">
                <a href="/discussions" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Discussions
                </a>
            </div>

            <div class="form-container">
                <div class="form-header">
                    <div class="form-title">
                        <i class="fas fa-comments form-icon"></i>
                        <h1>Start a New Discussion</h1>
                    </div>
                    <p class="form-description">
                        Share your thoughts, ask questions, or start a conversation with the community.
                    </p>
                </div>

                <div class="form-content">
                    <form id="discussionForm" class="discussion-form" method="POST" action="{{ route('discussions.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="form-label">
                                Discussion Title *
                            </label>
                            <input type="text" id="title" name="title"
                                   placeholder="What would you like to discuss?"
                                   class="form-input">
                                   @error('title')
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
                        </div>

                        <div class="form-group">
                            <label for="category" class="form-label">
                                Category *
                            </label>
                            <select id="category" name="category"  class="form-select">
                                 <option value="" disabled selected>Select a category</option>
                                @foreach ( $categories as $category )
                                <option  value="{{ $category->id }}"
                                            {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
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
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">
                                Your Message *
                            </label>
                            <textarea id="content" name="content"
                                      placeholder="Share your thoughts, ask questions, or provide details..."
                                      class="form-textarea"></textarea>
                                      @error('title')
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
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                Post Discussion
                            </button>
                            <a href="/discussions" class="cancel-btn">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</x-app-layout>

