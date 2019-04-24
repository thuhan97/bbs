<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BBS') }} @hasSection('page-title') | @yield('page-title') @endif</title>

    <!-- Styles -->
    <link href="{{ cdn_asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
    {{--<link href="{{ cdn_asset('mdb/css/mdb.min.css') }}" rel="stylesheet">--}}
    <link href="{{ cdn_asset('css/complied.css') }}" rel="stylesheet">
    <link href="{{ cdn_asset('css/mdb.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{ cdn_asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ cdn_asset('css/addons/datatables.min.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ cdn_asset('mdb/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('mdb/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('mdb/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('js/addons/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('js/sweetalert.min.js') }}"></script>
    @stack('extend-css')
</head>
<body>
@include('layouts.partials.frontend.header')

<main id="app" class="pt-5 mx-lg-5">
    <div class="container-fluid mt-5">
        @if(View::hasSection('breadcrumbs'))
            @yield('breadcrumbs')
        @endif
        @include('flash::message')

        @yield('content')
    </div>
</main>

<!-- Scripts -->
<script type="text/javascript" src="{{ cdn_asset('js/mdb.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ cdn_asset('js/main.js') }}"></script>
@stack('extend-js')
</body>
</html>
