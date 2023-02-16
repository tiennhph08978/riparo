<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="linhnq">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/icon/favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/toastr.min.css') }}">
    <title>@yield('title')</title>

    @yield('styles')
    @vite([
        'resources/assets/css/boostrap.min.css',
        'resources/sass/admin/app.scss',
    ])
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
</head>
    <body>
        <div id="wrapper">
            @include('admin.includes.topbar')

            @include('admin.includes.sidebar')

            @include('sweetalert::alert')

        <div class="content-wrapper h-auto">
            @yield('content')
        </div>

            @include('admin.includes.footer')
        </div>

        @include('admin.layouts.script')
        @yield('scripts')
    </body>
</html>
