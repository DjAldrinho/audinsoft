@extends('layouts.layout')

@section('title', 'Detalles de la reserva')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Reservas')

        Detalles de la reserva

    @endcomponent

@endsection


@section('content')

    <div class="row">
        <div class="col-md-8">
            @if(session('mensaje'))
                @component('layouts.components.callout', ['style' => 'success'])

                    @slot('title', 'Exito')

                    {{session('mensaje')}}

                @endcomponent
            @endif
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Reserva #{{$reserva->codigo_reserva}}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td><b>Responsable</b></td>
                                <td>{{$reserva->usuario->nombreCompleto}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha de reserva</b></td>
                                <td>{{$reserva->fecha_reserva->format('d/m/Y')}}</td>
                            </tr>
                            @if($reserva->fecha_final_reserva)
                                <tr>
                                    <td><b>Fecha final de reserva</b></td>
                                    <td>{{$reserva->fecha_final_reserva->format('d/m/Y')}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Hora Inicio</b></td>
                                <td>{{$reserva->hora_inicio}}</td>
                            </tr>
                            <tr>
                                <td><b>Hora Final</b></td>
                                <td>{{$reserva->hora_final}}</td>
                            </tr>
                            @if(isset($reserva->aula))
                                <tr>
                                    <td><b>Aula</b></td>
                                    <td>{{$reserva->aula->nombre or 'NA'}}</td>
                                </tr>
                            @endif
                            @if(Auth::user()->superadministrador)
                                <tr>
                                    <td><b>Dependencia</b></td>
                                    <td>{{ucwords($reserva->dependencia)}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Tipo</b></td>
                                <td>{{ucwords($reserva->tipo)}}</td>
                            </tr>
                            <tr>
                                <td><b>Descripcion</b></td>
                                <td>{{$reserva->descripcion or 'NA'}}</td>
                            </tr>
                            <tr>
                                <td><b>Fecha de creacion</b></td>
                                <td>{{$reserva->created_at->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td><b>Estado</b></td>
                                <td>{{$reserva->estado}}</td>
                            </tr>
                            @if(isset($reserva->administrador))
                                <tr>
                                    <td><b>Revisado por</b></td>
                                    <td>{{$reserva->administrador->nombreCompleto}}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    @can('modify',$reserva)
                        @if($reserva->estado === 'Aprobada')
                            <a href="{{route('marcar-reserva', $reserva)}}" class="btn bg-purple-active btn-flat"
                               onclick="return confirm('Esta seguro que desea marcar como activa?')">
                                <i class="fa fa-bookmark-o"></i> Marcar Reserva como activa
                            </a>
                        @elseif($reserva->estado === 'Pendiente')

                            <a href="{{route('aprobar-reserva', $reserva)}}" class="btn bg-green-active btn-flat"
                               onclick="return confirm('Esta seguro que desea aprobar?')">
                                Aprobar Reserva <i class="fa fa-check-circle"></i>
                            </a>


                            <a href="#" class="btn btn-flat btn-danger" data-toggle="modal"
                               data-target="#rechazar-reserva">
                                Rechazar Reserva <i class="fa fa-times-circle"></i>
                            </a>
                        @endif
                    @endcan

                    @can('view', $reserva)
                        @if($reserva->estado != 'Finalizada')
                            <a href="{{route('finalizar-reserva', $reserva)}}" class="btn btn-flat bg-orange-active"
                               onclick="return confirm('Esta seguro que desea finalizar?')">
                                Finalizar Reserva <i class="fa fa-flag-checkered"></i>
                            </a>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @component('layouts.components.box-collapsible', ['style' => 'info'])

                @slot('title', 'Activos de la reserva')

                @if(count($reserva->activos) > 0)
                    <div class="list-group">
                        @foreach($reserva->activos as $activo)
                            {!! link_to_route('ver-activo', $activo->nombre, $activo->id, ['class' => 'list-group-item list-group-item-action']) !!}
                        @endforeach
                    </div>
                @else
                    Esta reserva no contiene activos
                @endif
            @endcomponent
        </div>

        <div class="modal fade" id="rechazar-reserva" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    {!! Form::open(['route' => ['rechazar-reserva', $reserva], 'method' => 'put']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>


                        <h4 class="modal-title">Rechazar Reserva</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::textArea('motivo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Motivo del rechazo']) !!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Rechazar Reserva', ['class' => 'btn btn-warning']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection