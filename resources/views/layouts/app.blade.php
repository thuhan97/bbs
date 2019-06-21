<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if($config->lastest_event_image)
        <?php
        $imageUrl = url($config->lastest_event_image);
        ?>
        <meta property="og:image" content="{{$imageUrl}}">
        <meta itemprop="image" content="{{$imageUrl}}">
    @endif

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
