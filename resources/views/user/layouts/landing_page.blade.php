<!DOCTYPE html>
<html lang="en">
@include('user.partials.head')
<body id="landing-page">
@include('user.partials.navbar')
<div class="content-container">
    @include('sweetalert::alert')
    @yield('banner')
    @yield('bread-crumb')
    @yield('content')
</div>
@include('user.partials.footer_landing')
@include('user.partials.script')
</body>
</html>
