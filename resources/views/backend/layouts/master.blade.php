<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('backend.layouts.includes.css')
    

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            @include('backend.layouts.includes.loader')
        </div>

        @include('backend.layouts.includes.header')
        @include('backend.layouts.includes.sidebar')

        @yield('content')


        @include('backend.layouts.includes.footer')
    </div>
    <!-- ./wrapper -->

    @include('backend.layouts.includes.script')

</body>

</html>
