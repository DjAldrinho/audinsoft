<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro de usuarios | {{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte/skin-red.min.css') }}" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset('js/iCheck/all.css')}}" rel="stylesheet">


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


<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{url('/')}}" class="navbar-brand"><b>Audin</b>Soft</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Registro de usuarios
                    <small>Seleccione un rol</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Estudiantes/Egresados</h3>
                            </div>
                            <div class="box-body">
                                <div class="thumbnail">
                                    <a href="{{url('register', 'estudiantes-egresados')}}">
                                        <img src="{{asset('images/student-icon.png')}}"
                                             alt="Registro de estudiantes o egresados">
                                    </a>

                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                Si eres un estudiante o egresado ingresa <a
                                        href="{{url('register', 'estudiantes-egresados')}}">aqui</a>.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Docentes o administrativos</h3>
                            </div>
                            <div class="box-body">
                                <div class="thumbnail">
                                    <a href="{{route('get-register', 'docentes-administrativos')}}">
                                        <img src="{{asset('images/teacher-icon.png')}}"
                                             class="img-responsive"
                                             alt="Registro de docentes o administrativos">
                                    </a>
                                </div>
                            </div>
                            <div class="box-footer">
                                Si eres un docente o administrativo ingresa <a
                                        href="{{route('get-register', 'docentes-administrativos')}}">aqui</a>.
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->

        <br><br><br><br/>
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
</div>
<!-- Javascript -->

<!-- jQuery 3 -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- APP -->
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>
</body>
</html>