<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/icon/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    @vite([
        'resources/assets/css/boostrap.min.css',
        'resources/assets/css/custom.css',
        'resources/sass/user/app.scss',
    ])
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    @yield('head')
</head>
