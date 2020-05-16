<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layout') | {{ config('app.name') }}</title>
    <!-- Styles -->

    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
    <link href="{{ asset('css/adminlte/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte/skin-red.min.css') }}" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset('js/iCheck/all.css')}}" rel="stylesheet">
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('js/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('js/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Angular -->
    <link href="{{  asset('css/angular-moment/angular-moment-picker.min.css')  }}" rel="stylesheet"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
@include('layouts.includes.header')
<!-- Left side column. contains the logo and sidebar -->
@include('layouts.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @yield('content-header')
    <!-- Main content -->
        <section class="content container-fluid">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Software para reservas
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#">Universidad del Sinú</a>.</strong> Todos los derechos reservados.
    </footer>
</div>
<!-- Javascript -->

<!-- jQuery 3 -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Bootstrap Typeahead -->
<script src="{{ asset('css/bootstrap/js/typeahead.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('js/iCheck/icheck.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('js/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- APP -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>
<!-- Angular -->
<script src="{{ asset('js/angular/angular.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('js/moment/moment.js') }}"></script>
<script src="{{ asset('js/moment/moment-es.js') }}"></script>
<!-- Angular + Moment -->
<script src="{{ asset('js/angular/angular-moment-picker.min.js') }}"></script>
<!-- Reservas Module -->
<script src="{{ asset('js/angular/reservas-module.js') }}"></script>
<!-- Gestionar Module -->
<script src="{{ asset('js/angular/gestionar-module.js') }}"></script>
</body>
</html>