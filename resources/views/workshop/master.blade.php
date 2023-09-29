<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light"
      data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title> @yield('title') | Hybrix - Laravel 10 Admin & Dashboard Template </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @vite('resources/scss/app.scss')
    @include('layouts.head-css')
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
    @include('workshop.topbar')
    @include('workshop.top-tagbar')
    @include('workshop.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('workshop.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

@include('workshop.customizer')
<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
@stack('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @stack('onload-excute')
        console.log('dom content loaded');
    });
</script>
</body>
</html>
