<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light"
      data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @stack('scss')
    @include('workshop.head-css')
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->
@vite('resources/js/app.js')
@stack('scripts')
<script>
        document.addEventListener("DOMContentLoaded", function() {
        console.log('DOMContentLoaded');
        @stack('DOMContentLoaded')
    });
        document.addEventListener('livewire:initialized', () => {
        console.log('livewire:initialized');
        @stack('livewire:initialized')
    });
</script>
</body>
</html>
