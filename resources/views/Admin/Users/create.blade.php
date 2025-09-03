@extends('Admin.Layouts.app')

@section('title', 'Add User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/product-add.css') }}">
@endpush

@section('page-content')

    <div class="admin-layout">

        <main class="admin-content">
            <div class="container">
                <div class="page-header">
                    <div class="breadcrumb">
                        <a href="/admin/users" class="breadcrumb-link">Users</a>
                        <i class="fas fa-chevron-right"></i>
                        <span class="breadcrumb-current">Add User</span>
                    </div>
                </div>

                <div class="add-form-card">
                    <div class="card-header">
                        <h2 class="card-title">User Information</h2>
                        <p class="card-description">Fill in the details to create a new user account</p>
                    </div>

                    <form class="product-form" method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" placeholder="Enter First Name"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
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
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter Last Name"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
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
                                <label for="email">Email </label>
                                <input type="email" id="email" name="email" placeholder="Enter Store Name"
                                    value="{{ old('email') }}">
                                @error('email')
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
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter Password">
                                @error('password')
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
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm Password">
                                @error('password_confirmation')
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
                                <label for="role">Role</label>
                                <select id="role" name="role" required>
                                    <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Select a
                                        Role</option>
                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="error">
                                        <!-- error SVG and message here -->
                                        <div class="error__title">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="phone"> Phone</label>
                                <input type="text" id="phone" name="phone" placeholder="+961 12345678"
                                    value="{{ old('phone') }}">
                                @error('phone')
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
                        </div>

                        <div class="form-actions">
                            <a href="/admin/users" name="product_cancel" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit" name="product_btn" class="btn-save">
                                <i class="fas fa-plus"></i>
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/admin/product-add.js') }}"></script>
    @endpush


@endsection
