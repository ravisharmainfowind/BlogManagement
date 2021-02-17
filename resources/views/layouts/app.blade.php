<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php

$sessionArray = Session::get(Request::segment('1'));

$APP_URL = url('/') . '/' . Request::segment('1') . '/';

?>

  <script>

    var API_URL =  "{{ url('api') . '/'.Request::segment('1') }}/";
    var APP_URL =  "{{ url('/') . '/'.Request::segment('1') }}/";
    var SITEURL = "{{ url('/') }}/";
   
  </script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="{{ asset('public/front/css/simple-sidebar.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                    <?php      
             if ($sessionArray = Session::get('user')) { ?>
                <li><a href="{{ url('/logout') }}">Log Out</a></li>  
            <?php }else{ ?>
                <li><a href="{{ url('/login') }}">Sign In</a></li>                  
            <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="{{ asset('public/front/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('public/front/js/popper.min.js') }}"></script>
<script src="{{ asset('public/front/js/fabric.min.js') }}"></script>
<script src="{{ asset('public/front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('public/front/js/custom.js') }}"></script>
<!-- <script src="{{ asset('public/front/js/pickr.es5.min.js') }}"></script> -->
<script src="{{ asset('public/AdminTheme/app-assets/js/core/libraries/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/AdminTheme/app-assets/vendors/js/extensions/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/AdminTheme/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
<script src="{{ asset('public/AdminTheme/assets/js/scripts.js') }}"></script>
<script src="{{ asset('public/AdminTheme/app-assets/js/core/libraries/jquery.validate.min.js') }}"></script>
</html>