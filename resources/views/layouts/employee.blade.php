<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!-- App css -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap'
        type='text/css' />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jQuery.mmenu/5.6.1/css/jquery.mmenu.all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    @yield('head')
</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
    <div id="preloader">
        <div id="status">
            <div class="spinner-border avatar-md text-dark" role="status"></div>
        </div>
    </div>
    <div class="wrapper">
        @include('frontend.includes.navbar')
        <div class="container">
            <div class="row my-3">
                <div class="col-md-3 col-lg-3">
                    @include('employee.includes.sidebar')
                </div>
                <div class="col-md-9 col-lg-9">
                    @include('frontend.includes.flash-message')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('frontend.includes.footer')
    </div>
    @include('frontend.includes.script')
    <script>
        $(document).ready(function() {

            $("#Showmenu").click(function() {
                $(".leftside-menu").show();
                $("#Hidemenu").show();
                $("#Showmenu").hide();
            });

            $("#Hidemenu").click(function() {
                $(".leftside-menu").hide();
                $("#Showmenu").show();
                $("#Hidemenu").hide();
            });

        });
    </script>
</body>

</html>
