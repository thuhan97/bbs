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

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset_ver('/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset_ver('/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Plugins -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset_ver('/adminlte/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css">
    <!-- Select2 -->
    <link href="{{ asset_ver('/adminlte/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- datetimepicker -->
    <link href="{{ asset_ver('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css">
    <!-- END - Plugins -->

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset_ver('/adminlte/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skin. -->
    <link rel="stylesheet" href="{{ asset_ver('/adminlte/css/skins/' . config('adminlte.theme') . '.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset_ver('/css/backend.css?version=' . config('adminlte.version')) }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
</body>
</html>
