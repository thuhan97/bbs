<?php
$imageUrl = url($config->lastest_event_image);
?>
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta property="og:image" content="{{$imageUrl}}">
    <meta itemprop="image" content="{{$imageUrl}}">
    @include('layouts.partials.frontend.meta')

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
