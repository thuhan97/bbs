<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow, noarchive">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') @hasSection('page-subtitle') | @yield('page-subtitle') @endif</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Plugins -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset('/adminlte/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css">
    <!-- Select2 -->
    <link href="{{ asset('/adminlte/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- datetimepicker -->
    <link href="{{ asset('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link href="{{ asset('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css">
    <!-- END - Plugins -->

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skin. -->
    <link rel="stylesheet" href="{{ asset('/adminlte/css/skins/' . config('adminlte.theme') . '.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('/css/backend.css?version=' . config('adminlte.version')) }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('head-extras')
</head>

<body class="hold-transition {{ config('adminlte.theme') }} sidebar-mini">
@auth
    <script type="text/javascript">
        /* Recover sidebar state */
        (function () {
            if (Boolean(localStorage.getItem('sidebar-toggle-collapsed'))) {
                var body = document.getElementsByTagName('body')[0];
                body.className = body.className + ' sidebar-collapse';
            }
        })();
    </script>
@endauth

<!-- Site wrapper -->
<div class="wrapper">

@include('layouts.partials.backend.header')

@include('layouts.partials.backend.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page-title')
                <small>@yield('page-subtitle')</small>
            </h1>
            @yield('breadcrumbs')
        </section>

        <!-- Main content -->
        <section class="content">

            @include('flash::message')

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ config('adminlte.version') }}
        </div>
        <strong>Copyright &copy; {{ date('Y') }}. {!! config('adminlte.credits') !!}</strong>. All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
<input type="file" id="file_editor_upload" class="hidden">
<!-- jQuery 3 -->
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('/adminlte/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/adminlte/plugins/fastclick/fastclick.js') }}"></script>

<!-- Plugins -->
<!-- iCheck for checkboxes and radio inputs -->
<script src="{{ asset('/adminlte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/adminlte/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<!-- Moment Js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<!-- DatetimePicker Js-->
<script src="{{ asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<!-- END - Plugins -->

<!-- AdminLTE App -->
<script src="{{ asset('/adminlte/js/adminlte.min.js') }}"></script>
<!-- Custom Js -->
<script src="{{ asset('/js/backend.js?version=' . config('adminlte.version')) }}"></script>
<script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script src="{{asset('/js/admin.js')}}"></script>
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

@yield('footer-extras')

@stack('footer-scripts')
</body>
</html>
