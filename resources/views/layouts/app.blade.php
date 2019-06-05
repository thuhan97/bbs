<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <link rel="icon" type="image/png" href="/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BBS') }}</title>

    <!-- Styles -->
    <link href="{{ asset_ver('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset_ver('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset_ver('css/style.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">
    @yield('content')
</div>

<!-- Scripts -->
<script type="text/javascript" src="{{ asset_ver('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_ver('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_ver('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset_ver('js/mdb.min.js') }}"></script>
@yield('js-extend')
</body>
</html>
