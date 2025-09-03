<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/main-content.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/footer.css') }}">

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/admin/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <!-- Notifications -->
    @include('Admin.partials.notification')
</body>
</html>
