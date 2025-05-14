<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | Report NEO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('build/img/AdminLTELogo.png')}}">
        @include('layouts.head-css')        
    </head>
@section('body')
@include('layouts.body')
@show
    @include('layouts.page-loader')
    @include('sweetalert::alert')
    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <!-- [ Layout inner ] Start -->
        <div class="layout-inner">
            @include('layouts.sidenav')
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                @include('layouts.navbar-header')
                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">@yield('title-page') </h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">@yield('title-active')</li>
                            </ol>
                        </div>
                        @yield('content')
                    </div>
                    <!-- [ content ] End -->
                </div>
                <!-- [ Layout content ] End -->
                @include('layouts.footer')
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- [ layout inner] End -->
    </div>
    <!-- [ Layout wrapper] End -->
    @include('layouts.vendor-scripts')