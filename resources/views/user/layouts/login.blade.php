<!DOCTYPE html>
<html lang="en">
@include('user.partials.head')
<body class="scrollbar-hidden">
@yield('banner')
<div class="login-wrapper">
    <div class="login">
        @yield('bread-crumb')
        @yield('content')
    </div>
    @include('user.partials.footer_login')
</div>
@include('user.partials.script')
</body>
</html>
