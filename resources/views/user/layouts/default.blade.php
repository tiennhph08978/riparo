<!DOCTYPE html>
<html lang="en">
@include('user.partials.head')
<body>
    <div style="position: relative; height: calc(100vh - 99px);">
        @if(!Route::is('login') )
            @include('user.partials.navbar')
        @endif
        @yield('banner')
        <div class="container m-auto" style="height: 100%">
            @yield('bread-crumb')
            @yield('content')
        </div>
        @include('user.partials.footer')
    </div>
    @include('user.partials.script')
    @yield('script')
</body>
</html>
