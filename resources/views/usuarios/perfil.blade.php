@extends('layouts.layout')

@section('title', 'Perfil de '.$user->nombreCompleto)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Usuarios')

        Perfil de usuario

    @endcomponent

@endsection


@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{$user->nombreCompleto}}</h3>

                    <p class="text-muted text-center">{{$user->tipo}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Fecha de registro</b> <a class="pull-right">{{$user->created_at->format('d/m/Y')}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Estado</b> <a class="pull-right">{{$user->estado}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Estado Audiovisuales</b>
                            <a class="pull-right">{{$user->isBloqueado('Audiovisuales')?'Baneado':'Activo'}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Estado Bienestar</b>
                            <a class="pull-right">{{$user->isBloqueado('Bienestar Universitario')?'Baneado':'Activo'}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Estado Infraestructura</b>
                            <a class="pull-right">{{$user->isBloqueado('Infraestructura')?'Baneado':'Activo'}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Reservas</b> <a class="pull-right">{{count($user->reservas)}}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Mas Información</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-envelope-o margin-r-5"></i> Email</strong>

                    <p class="text-muted">
                        {{$user->email}}
                    </p>

                    <hr>

                    <strong><i class="fa fa-id-card margin-r-5"></i> Identificacion</strong>

                    <p class="text-muted">{{$user->identificacion}}</p>

                    <hr>

                    <strong><i class="fa fa-phone-square margin-r-5"></i> Telefono</strong>

                    <p class="text-muted">{{$user->telefono}}</p>

                    <hr>

                    @if(isset($user->escuela))
                        <strong><i class="fa fa-university margin-r-5"></i> Escuela</strong>
                        <p class="text-muted">{{$user->escuela}}</p>
                        <hr>
                        <strong><i class="fa fa-id-card margin-r-5"></i> Codigo de usuario</strong>
                        <p class="text-muted">{{$user->codigo_usuario}}</p>
                        <hr>
                    @endif
                    @if(isset($user->dependencia))
                        <strong><i class="fa fa-star-o margin-r-5"></i> Dependencia</strong>
                        <p class="text-muted">{{$user->dependencia}}</p>
                        <hr>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-8">
            @if(session('mensaje'))
                @component('layouts.components.alert', ['style' => 'success', 'icon' => 'check-square'])

                    @slot('title', 'Exito!')

                    {{session('mensaje')}}

                @endcomponent
            @endif

            @if(session('mensaje-error'))

                @component('layouts.components.alert', ['style' => 'danger', 'icon' => 'close'])

                    @slot('title', 'Error!')

                    {{session('mensaje-error')}}

                @endcomponent
            @endif
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ultimas reservas</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Codigo</td>
                                <td>Fecha</td>
                                <td>Hora Inicio</td>
                                <td>Hora Final</td>
                                <td>Activos</td>
                                <td>Aula</td>
                                <td>Tipo de reserva</td>
                                <td>Estado</td>
                            </tr>
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td>{{$reserva->codigo_reserva}}</td>
                                    <td>{{$reserva->fecha_reserva->format('d/m/Y')}}</td>
                                    <td>{{$reserva->hora_inicio}}</td>
                                    <td>{{$reserva->hora_final}}</td>
                                    <td>{{count($reserva->activos)}}</td>
                                    <td>{{$reserva->aula->nombre or 'NA' }}</td>
                                    <td>
                                        @if($reserva->tipo == 'audiovisuales')
                                            <span class="badge bg-aqua-gradient">
                                                {{ucwords($reserva->tipo)}}
                                            </span>
                                        @elseif($reserva->tipo == 'infraestructura')
                                            <span class="badge bg-teal-gradient">
                                                {{ucwords($reserva->tipo)}}
                                            </span>
                                        @else
                                            <span class="badge bg-red-gradient">
                                                {{ucwords($reserva->tipo)}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>

                                        @if($reserva->estado == 'Aprobada')
                                            <span class="badge bg-green-active">{{str_replace("_", " ", $reserva->estado)}}</span>
                                        @elseif($reserva->estado == 'Rechazada')
                                            <span class="badge bg-red-active">{{str_replace("_", " ", $reserva->estado)}}</span>
                                        @elseif($reserva->estado == 'Pendiente')
                                            <span class="badge bg-yellow-active">{{str_replace("_", " ", $reserva->estado)}}</span>
                                        @else
                                            <span class="badge bg-navy-active">{{str_replace("_", " ", $reserva->estado)}}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div align="center">
                @if(Auth::user()->id != $user->id)
                    <a href="{{url('usuarios/contactar', Crypt::encrypt($user->id))}}" class="btn btn-primary">
                        <i class="fa fa-envelope-o"></i> Contactar
                    </a>
                @endif

                @can('banear',App\User::class)
                    @if(($user->isBloqueado(Auth::user()->dependencia) or Auth::user()->superadministrador)
                    and $user->id != Auth::user()->id)
                        <a href="#" class="btn bg-olive-active" data-toggle="modal"
                           data-target="#habilitar-usuario">
                            <i class="fa fa-check-circle"></i> Habilitar Usuario
                        </a>

                        <div class="modal fade in " id="habilitar-usuario" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::open(['route' => ['habilitar-usuario', Crypt::encrypt($user->id)], 'method' => 'put']) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;
                                        </button>
                                        <h4 class="modal-title">Habilitar Usuario</h4>
                                    </div>
                                    <div class="modal-body">
                                        @if(Auth::user()->superadministrador)
                                            {!! Form::select('responsable', [''=>'Seleccione un responsable...','Audiovisuales'=>'Audiovisuales', 'Bienestar Universitario' => 'Bienestar Universitario','Infraestructura' =>'Infraestructura'],'', ['class' => 'form-control', 'required']) !!}
                                        @endif
                                        <br/>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Habilitar Usuario', ['class' => 'btn bg-olive-active']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if((!$user->isBloqueado(Auth::user()->dependencia) or Auth::user()->superadministrador)
                    and $user->id != Auth::user()->id)
                        <a href="#" class="btn bg-red-active" data-toggle="modal" data-target="#banear-usuario">
                            <i class="fa fa-ban"></i> Banear Usuario
                        </a>

                        <div class="modal fade in" id="banear-usuario" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::open(['route' => ['banear-usuario', Crypt::encrypt($user->id)], 'method' => 'put']) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;
                                        </button>
                                        <h4 class="modal-title">Banear Usuario</h4>
                                    </div>
                                    <div class="modal-body">
                                        @if(Auth::user()->superadministrador)
                                            {!! Form::select('responsable', [''=>'Seleccione un responsable...','Audiovisuales'=>'Audiovisuales', 'Bienestar Universitario' => 'Bienestar Universitario','Infraestructura' =>'Infraestructura'],'', ['class' => 'form-control', 'required']) !!}
                                        @endif
                                        <br/>
                                        {!! Form::textArea('motivo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Motivo del baneo']) !!}
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Banear Usuario', ['class' => 'btn bg-red-active']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
@endsection