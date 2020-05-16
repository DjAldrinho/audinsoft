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
<body class="hold-transition register-page">
<div class="register-box" ng-app="register_module" ng-cloak>
    <div class="register-logo">
        <a href="{{url('/')}}"><b>Audin</b>Soft</a>
    </div>

    <div class="register-box-body" ng-controller="registerController">

        <p class="login-box-msg">Registrar nuevo usuario</p>

        <div class="form-group has-feedback" ng-class="{'has-success': success, 'has-error': error}">
            <div class="input-group margin">
                <input type="text" class="form-control" placeholder="Ingrese su identificación"
                       name="codigo_identificacion"
                       ng-model="codigo_identificacion" ng-required="true"/>
                <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat"
                              ng-click="searchUser()">Go!</button>
                </span>
            </div>
            <span class="help-block" ng-bind="mensaje"></span>
        </div>

        {!! Form::open(['route' => 'post-register', 'method' => 'post']) !!}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" name="email" required ng-model="usuario.email" readonly
                   placeholder="{{old('email')}}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if($errors->has('email'))
                <span class="help-block">
                    <strong>
                        {{ $errors->first('email') }}
                    </strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" required
                   placeholder="Ingrese una contraseña segura">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback">
            <input id="password-confirm" type="password" class="form-control"
                   name="password_confirmation" required placeholder="Confirme su contraseña">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback {{ $errors->has('nombre') ? ' has-error' : '' }}">
            <input type="text" class="form-control" placeholder="{{old('nombre')}}" readonly ng-model="usuario.nombre"
                   name="nombre">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if($errors->has('nombre'))
                <span class="help-block">
                  <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('identificacion') ? ' has-error' : '' }}">
            <input type="text" class="form-control" placeholder="{{old('identificacion')}}" readonly
                   ng-model="usuario.identificacion" name="identificacion">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if ($errors->has('identificacion'))
                <span class="help-block">
                  <strong>{{ $errors->first('identificacion') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('telefono') ? ' has-error' : '' }}">
            <input type="text" class="form-control" placeholder="{{old('telefono')}}" readonly
                   ng-model="usuario.telefono" name="telefono">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>

            @if($errors->has('telefono'))
                <span class="help-block">
                  <strong>{{ $errors->first('telefono') }}</strong>
                </span>
            @endif
        </div>
        @if($tipo == 'docentes-administrativos')
            <div class="form-group has-feedback {{$errors->has('rol')?'has-error':''}}">
                <select name="rol" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Docente">Docente</option>
                </select>
                @if ($errors->has('rol'))
                    <span class="help-block">
                    <strong>{{ $errors->first('rol') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('dependencia') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="{{old('dependencia')}}"
                       autocomplete="off" name="dependencia" ng-model="usuario.dependencia" readonly>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('dependencia'))
                    <span class="help-block">
                  <strong>{{ $errors->first('dependencia') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('cargo') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Cargo"
                       autocomplete="off" name="cargo">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('cargo'))
                    <span class="help-block">
                  <strong>{{ $errors->first('cargo') }}</strong>
                </span>
                @endif
            </div>
        @endif
        @if($tipo == 'estudiantes-egresados')
            <div class="form-group has-feedback {{$errors->has('rol')?'has-error':''}}">
                <select name="rol" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="Estudiante">Estudiante</option>
                    <option value="Egresado">Egresado</option>
                </select>
                @if ($errors->has('rol'))
                    <span class="help-block">
                    <strong>{{ $errors->first('rol') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('escuela') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="{{old('escuela')}}"
                       autocomplete="off" name="escuela" ng-model="usuario.escuela" readonly>
                <span class="fa fa-university form-control-feedback"></span>
                @if ($errors->has('escuela'))
                    <span class="help-block">
                  <strong>{{ $errors->first('escuela') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('semestre') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="{{old('semestre')}}"
                       autocomplete="off" name="semestre" ng-model="usuario.semestre" readonly>
                <span class="fa fa-university form-control-feedback"></span>
                @if ($errors->has('semestre'))
                    <span class="help-block">
                  <strong>{{ $errors->first('semestre') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{$errors->has('jornada')?'has-error':''}}">
                <select name="jornada" required class="form-control">
                    <option value="">Seleccione una jornada</option>
                    <option value="Diurna">Diurna</option>
                    <option value="Nocturna">Nocturna</option>
                </select>
                @if ($errors->has('jornada'))
                    <span class="help-block">
                    <strong>{{ $errors->first('jornada') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('codigo_usuario') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Codigo de usuario"
                       autocomplete="off" name="codigo_usuario">
                <span class="fa fa-university form-control-feedback"></span>
                @if ($errors->has('codigo_usuario'))
                    <span class="help-block">
                  <strong>{{ $errors->first('codigo_usuario') }}</strong>
                </span>
                @endif
            </div>

        @endif
        <div class="row">
            <div class="col-xs-8">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="terminos" class="minimal-red"> Acepto los <a href="#">terminos</a>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Registro</button>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            @if($errors->has('terminos'))
                @component('layouts.components.alert', ['style' => 'warning', 'dimissible' => true, 'icon' => 'warning'])
                    @slot('title', 'Terminos y condiciones')
                    Por favor acepte terminos y condiciones
                @endcomponent
            @endif
        </div>
        {!! Form::hidden('tipoRegistro', $tipo, ['id' => 'hdnTipoRegistro']) !!}
        {!! Form::close() !!}
        <a href="{{route('login')}}" class="text-center">Tengo una cuenta...</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>
<script src="{{ asset('js/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('css/bootstrap/js/typeahead.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/angular/angular.js') }}"></script>
<script src="{{ asset('js/angular/register-module.js') }}"></script>
</body>
</html>
