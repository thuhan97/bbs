<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BBS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('mdb/css/mdb.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/complied.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('mdb/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>

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
<script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@stack('extend-js')
@stack('eu-dayoff')
</body>
</html>
