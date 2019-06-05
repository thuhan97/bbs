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
    <link href="{{ asset_ver('css/complied.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{ asset_ver('css/addons/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset_ver('css/notification.css') }}?v={{date('Ymd')}}-1" rel="stylesheet">
    <link href="{{ asset_ver('css/style.css') }}?v={{date('Ymd')}}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset_ver('mdb/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_ver('mdb/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_ver('mdb/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_ver('js/addons/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_ver('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script>
        window.userId = '{{\Illuminate\Support\Facades\Auth::id()}}';
        window.system_image = '{{JVB_LOGO_URL}}';
        @if(config('app.env') != 'production')
            Pusher.logToConsole = true;
        @endif
            window.pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: 'ap1',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}"
                }
            }
        });
    </script>
    @stack('extend-css')
</head>
<body>
@include('layouts.partials.frontend.header')

<main id="app" class="p-t-2-2">
    <div class="container-fluid mt-3 m-t-4em">
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
<script src="{{asset_ver('js/tinymce/tinymce.min.js')}}"></script>
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
<script type="text/javascript" src="{{ asset_ver('js/mdb.min.js?v=1') }}"></script>
<script type="text/javascript" src="{{ asset_ver('js/moment-with-locales.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset_ver('mdb/js/compiled.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ asset_ver('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset_ver('js/notify.js') }}"></script>

@stack('extend-js')
</body>
</html>
