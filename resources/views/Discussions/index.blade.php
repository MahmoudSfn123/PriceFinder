 <x-app-layout title='Discussions'>

     @push('styles')
         <link href="{{ asset('assets/css/discussions.css') }}" rel="stylesheet">
     @endpush

     <x-slot:firstpage>
         <div class="breadcrumb-section breadcrumb-bg">
             <div class="container">
                 <div class="row">
                     <div class="col-lg-8 offset-lg-2 text-center">
                         <div class="breadcrumb-text">
                             <p>ask questions, and connect with others.</p>
                             <h1>Discussions</h1>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </x-slot:firstpage>


     <!-- Main Content -->
     <main class="main-content">
         <div class="container">
             <div class="page-header">
                 <div class="page-info">
                     <div class="back-button">
                         <a href="/" class="back-link">
                             <i class="fas fa-arrow-left"></i>
                             Back to Home
                         </a>
                     </div>
                     <p class="page-description">Talk about deals, products, and more with the community.</p>
                 </div>
                 <a href="{{ route('discussions.create') }}" class="start-discussion-btn">
                     <i class="fas fa-plus"></i>
                     Start a New Discussion
                 </a>
             </div>

             <div class="discussions-container">
                 <div class="discussions-list">
                     @foreach ($discussions as $discussion)
                         <a class="discussion-item-link" href="{{ route('discussions.show', $discussion->id) }}">
                             <div class="discussion-item {{ $discussion->locked ? 'locked' : '' }}">
                                 <div class="discussion-content">
                                     <div class="discussion-meta">
                                         <span class="discussion-category">{{ $discussion->category->name }}</span>
                                         @if ($discussion->locked)
                                             <i class="fas fa-lock lock-icon"></i>
                                         @endif
                                     </div>
                                     <p class="discussion-title">
                                         @if ($discussion->locked)
                                             <i class="fas fa-lock"></i>
                                         @endif
                                         {{ $discussion->topic }}
                                     </p>
                                     <p class="discussion-author">
                                         Started by
                                         <span class="author-name">{{ $discussion->author->first_name }}
                                             {{ $discussion->author->last_name }}</span>
                                         @if ($discussion->locked)
                                             <span class="locked-status">• Locked</span>
                                         @endif
                                     </p>
                                 </div>
                                 <div class="discussion-stats">
                                     <div class="replies-count">
                                         <i class="fas fa-comments"></i>
                                         <span class="count">{{ $discussion->replies->count() }}</span>
                                     </div>
                                     <p class="last-reply">
                                         Last reply
                                         {{ optional($discussion->lastPost)->created_at?->format('Y-m-d') ?? 'No replies yet' }}
                                     </p>
                                 </div>
                             </div>
                         </a>
                     @endforeach

                 </div>
             </div>
         </div>
     </main>
 </x-app-layout>
