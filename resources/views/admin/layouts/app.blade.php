<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-flags.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-payments.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/tabler-vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/demo.min.css') }}">
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        .table-responsive{
            min-height: 200px;
        }
      </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main content -->
    <div class="page">
        <!-- Navbar -->
        @include('admin.partials.navbar')

        <!-- Page content -->
        <div class="page-wrapper">
            @yield('content')
        </div>

        @include('admin.partials.footer')
    </div>

    <script src="{{ asset('admin/dist/js/demo-theme.js') }}"></script>
    <!-- Libs JS -->
    <script src="{{ asset('admin/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jsvectormap/dist/js/jsvectormap.js') }}"></script>
    <script src="{{ asset('admin/dist/libs/jsvectormap/dist/maps/world.js') }}"></script>
    <!-- Tabler Core -->
    <script src="{{ asset('admin/dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/demo.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
