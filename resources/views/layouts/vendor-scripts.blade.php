<script src="{{ URL::asset('assets/js/pace.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/popper/popper.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ URL::asset('assets/js/sidenav.js') }}"></script>
<script src="{{ URL::asset('assets/js/layout-helpers.js') }}"></script>
<script src="{{ URL::asset('assets/js/material-ripple.js') }}"></script>

<script src="{{ URL::asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
@yield('script-Libs')

<script src="{{ URL::asset('assets/js/app.js') }}"></script>
<script src="{{ URL::asset('assets/js/analytics.js') }}"></script>
@yield('script-page')

@yield('script-bottom')
