@extends('Admin.Layouts.base')

@section('title', $title ?? 'Admin')

@section('content')
    @include('Admin.partials.navbar')

    <div class="admin-layout"> {{-- flex container for sidebar + main content --}}
        @include('Admin.partials.sidebar')

        <div class="admin-main">
            <main class="main-content">
                @yield('page-content')
            </main>
            @include('Admin.partials.footer')
        </div>
    </div>

    @include('partials.notification')
@endsection
