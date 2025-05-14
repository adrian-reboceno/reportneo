

@yield('css-before')
<!-- Google fonts -->
<link href="{{ URL::asset('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700') }}" rel="stylesheet">

<!-- Icon fonts -->
<link rel="stylesheet" href="{{ URL::asset('Assets/fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/fonts/ionicons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/fonts/linearicons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/fonts/open-iconic.cs') }}s">
<link rel="stylesheet" href="{{ URL::asset('assets/fonts/pe-icon-7-stroke.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/fonts/feather.css') }}">

<!-- Core stylesheets -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-material.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/shreerang-material.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/uikit.css') }}">

<!-- Libs -->
<link rel="stylesheet" href="{{ URL::asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
<!-- Page -->
{{-- <link rel="stylesheet" href="{{ URL::asset('assets/css/pages/authentication.css') }}"> --}}

@yield('css-after')