@extends('Admin.Layouts.app')

@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/users.css') }}">
@endpush

@section('page-content')

            <!-- users Content -->

                <div class="admin-container" style="margin-right: 20px">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">Users</h1>
                        <a href="{{ route('admin.users.create')}}" class="add-button">
                            <i class="fas fa-plus"></i>
                            Add User
                        </a>
                    </div>

                    <!-- Products Table Card -->
                    <div class="products-card">
                        <div class="card-header">
                            <h2 class="card-title">All Users</h2>
                            <div class="search-container">
                                <div class="search-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchInput" placeholder="Filter by name..."
                                        class="search-input">
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="table-container">
                                <table class="products-table">
                                    <thead>
                                        <tr class="table-header">
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Phone</th>
                                            <th>Joined</th>
                                            <th class="text-center actions-column">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="table-row">
                                                <td class="product-name">{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $user->is_admin ? 'role-badge admin' : 'role-badge user' }}">
                                                        {{ $user->is_admin ? 'Admin' : 'User' }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td class="actions-dropdown">
                                                    <button class="actions-trigger">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="{{ route('admin.users.edit',$user->id) }}" class="dropdown-item edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit User
                                                        </a>
                                                        <div class="dropdown-separator"></div>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" onsubmit="return confirmDeleteUser(event)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item delete">
                                                                <i class="fas fa-trash-alt"></i>
                                                                Delete User
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container" data-current-page="{{ $users->currentPage() }}"
                                data-last-page="{{ $users->lastPage() }}">
                                <div class="pagination">
                                    <button class="pagination-btn prev"
                                        @if (!$users->onFirstPage()) data-url="{{ $users->previousPageUrl() }}" @else disabled @endif>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>

                                    <div class="pagination-numbers">
                                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                                            <button class="page-number {{ $i == $users->currentPage() ? 'active' : '' }}"
                                                data-url="{{ $users->url($i) }}">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>

                                    <button class="pagination-btn next"
                                        @if ($users->hasMorePages()) data-url="{{ $users->nextPageUrl() }}" @else disabled @endif>
                                        Next <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/admin/users.js') }}"></script>
    @endpush

@endsection
