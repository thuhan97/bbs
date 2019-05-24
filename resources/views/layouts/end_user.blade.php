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

    <title>{{ config('app.name', 'BBS') }} @hasSection('page-title') | @yield('page-title') @endif</title>

    <!-- Styles -->
    <link href="{{ cdn_asset('css/complied.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{ cdn_asset('css/addons/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ cdn_asset('css/style.css') }}?v={{date('Ymd')}}-1" rel="stylesheet">

    <script type="text/javascript" src="{{ cdn_asset('mdb/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('mdb/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('mdb/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('js/addons/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ cdn_asset('js/sweetalert.min.js') }}"></script>
    @stack('extend-css')
</head>
<body>
@include('layouts.partials.frontend.header')

<main id="app" class="pt-md-5">
    <div class="container-fluid mt-3 mt-xl-5">
        <div id="main">
            @if(View::hasSection('breadcrumbs'))
                @yield('breadcrumbs')
            @endif
            @include('flash::message')
            @yield('content')
        </div>
    </div>
</main>
<!-- editor -->
<script src="{{cdn_asset('/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    (function ($) {
        if (document.head.querySelector('meta[name="csrf-token"]')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    })(jQuery);
</script>
@stack('footer-scripts')

<!-- Scripts -->
<script type="text/javascript" src="{{ cdn_asset('js/mdb.min.js?v=1') }}"></script>
{{--<script type="text/javascript" src="{{ cdn_asset('/mdb/js/compiled.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ cdn_asset('js/main.js') }}"></script>

@stack('extend-js')
</body>
</html>
