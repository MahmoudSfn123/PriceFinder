@extends('Admin.Layouts.app')

@section('title', 'Discussions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/discussions.css') }}">
@endpush

@section('page-content')

    <!-- Admin Discussions Page -->
    <div class="admin-container">
        <!-- Header Section -->
        <div class="admin-page-header">
            <h1 class="page-title">Manage Discussions</h1>
        </div>

        <!-- Discussions Card -->
        <div class="admin-card">
            <div class="card-header">
                <h2 class="card-title">Community Forum</h2>
                <p class="card-description">Moderate and manage user discussions.</p>
            </div>

            <div class="card-content">
                <!-- Discussions Table -->
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr class="table-header-row">
                                <th class="table-header">Topic</th>
                                <th class="table-header">Category</th>
                                <th class="table-header">Author</th>
                                <th class="table-header text-center">Replies</th>
                                <th class="table-header">Last Post</th>
                                <th class="table-header text-center actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="discussions-tbody">
                            @foreach ($discussions as $discussion)
                                <tr class="table-row {{ $discussion->locked ? 'locked' : '' }}">
                                    <td class="table-cell font-medium">
                                        @if ($discussion->locked)
                                            <i class="fas fa-lock text-warning"></i>
                                        @endif
                                        {{ $discussion->topic }}
                                    </td>
                                    <td class="table-cell">{{ $discussion->category->name ?? 'N/A' }}</td>
                                    <td class="table-cell">{{ $discussion->author->first_name }} {{ $discussion->author->last_name }}</td>
                                    <td class="table-cell text-center">{{ $discussion->replies->count() }}</td>
                                    <td class="table-cell">
                                        {{ optional($discussion->lastPost)->created_at?->format('Y-m-d') ?? $discussion->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="table-cell text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.discussions.show', $discussion->id) }}" class="btn btn-view btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>

                                            <button class="btn btn-sm {{ $discussion->locked ? 'btn-unlock' : 'btn-lock' }}"
                                                onclick="toggleLockDiscussion({{ $discussion->id }}, {{ $discussion->locked ? 'true' : 'false' }})">
                                                <i class="fas {{ $discussion->locked ? 'fa-unlock' : 'fa-lock' }}"></i>
                                                {{ $discussion->locked ? 'Unlock' : 'Lock' }}
                                            </button>

                                            <button class="btn btn-danger btn-sm" onclick="deleteDiscussion({{ $discussion->id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container" data-current-page="{{ $discussions->currentPage() }}"
                    data-last-page="{{ $discussions->lastPage() }}">
                    <div class="pagination">
                        <button class="pagination-btn prev"
                            @if (!$discussions->onFirstPage()) data-url="{{ $discussions->previousPageUrl() ? $discussions->previousPageUrl() . '#store-entries' : '' }}" @else disabled @endif>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>

                        <div class="pagination-numbers">
                            @for ($i = 1; $i <= $discussions->lastPage(); $i++)
                                <button class="page-number {{ $i == $discussions->currentPage() ? 'active' : '' }}"
                                    data-url="{{ $discussions->url($i) . '#store-entries' }}">
                                    {{ $i }}
                                </button>
                            @endfor
                        </div>

                        <button class="pagination-btn next"
                            @if ($discussions->hasMorePages()) data-url="{{ $discussions->nextPageUrl() . '#store-entries' }}" @else disabled @endif>
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="custom-alert" class="alert d-none" role="alert"></div>

    @push('scripts')
        <script src="{{ asset('assets/js/admin/discussions.js') }}"></script>
    @endpush

@endsection
