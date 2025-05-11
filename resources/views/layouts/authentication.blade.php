<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
        <title>@yield('title') - {{ config('app.name') }}</title>
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
       
        @stack('before-styles')
        
        <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />  
        <link href="{{ URL::asset('assets/css/style.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        @stack('after-styles')
    </head>    
    
    <body class="theme-blush">
    <div class="authentication">
        <div class="container">
            @yield('content')
        </div>
    </div>

        <!-- Scripts -->
        @stack('before-scripts')
        <script src="{{ URL::asset('assets/bundles/libscripts.bundle.js') }}"></script>
   
        <script src="{{ URL::asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
     
        @stack('after-scripts')        
    </body>
</html>
