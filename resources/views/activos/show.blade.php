@extends('layouts.layout')

@section('title', 'Detalles de '.$activo->nombre)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Activos')

        Detalles del activo

    @endcomponent

@endsection


@section('content')

    <div class="row" ng-app="gestionar_module" ng-controller="gestionarActivosController" ng-cloak>
        <div class="col-md-8">
            @if(session('mensaje'))
                @component('layouts.components.callout', ['style' => 'success'])

                    @slot('title', 'Exito')

                    {{session('mensaje')}}

                @endcomponent
            @endif
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td><b>Nombre</b></td>
                                <td>{{$activo->nombre}}</td>
                            </tr>
                            <tr>
                                <td><b>Marca</b></td>
                                <td>{{$activo->marca}}</td>
                            </tr>
                            <tr>
                                <td><b>Modelo</b></td>
                                <td>{{$activo->modelo}}</td>
                            </tr>
                            @if(isset($activo->serial))
                                <tr>
                                    <td><b>Serial</b></td>
                                    <td>{{$activo->serial}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Tipo</b></td>
                                <td>{{$activo->tipo}}</td>
                            </tr>
                            <tr>
                                <td><b>Dependencia</b></td>
                                <td>{{$activo->dependencia}}</td>
                            </tr>
                            <tr>
                                <td><b>Cantidad</b></td>
                                <td>{{$activo->cantidad or 1}}</td>
                            </tr>
                            <tr>
                                <td><b>Creado</b></td>
                                <td>{{ucwords($activo->created_at->toDayDateTimeString())}}</td>
                            </tr>
                            @if($activo->created_at->toDayDateTimeString() != $activo->updated_at->toDayDateTimeString())
                                <tr>
                                    <td><b>Ultima Modificacion</b></td>
                                    <td>{{ucwords($activo->updated_at->toDayDateTimeString())}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Estado</b></td>
                                <td>{{str_replace("_", " ", $activo->estado)}}</td>
                            </tr>
                            @if(isset($activo->descripcion))
                                <tr>
                                    <td><b>Descripcion</b></td>
                                    <td>{{$activo->descripcion or 'NA'}}</td>
                                </tr>
                            @endif
                            @if(isset($activo->manual))
                                <tr>
                                    <td><b>Vista previa</b></td>
                                    <td><img src="{{$activo->manual}}" alt="Logo Activo"></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    @can('modify', $activo)
                        <a href="{{route('editar-activo', $activo)}}" class="btn btn-flat btn-primary">
                            <i class="fa fa-pencil"></i> Editar activo
                        </a>

                        <a href="{{route('marcar-activo', $activo)}}" class="btn btn-flat bg-navy-active">
                            <i class="fa fa-bookmark-o"></i> Marcar activo en mantenimiento
                        </a>
                    @endcan
                    {{--@can('delete', $activo)--}}
                    {{--<a href="{{route('eliminar-activo', $activo)}}" class="btn btn-danger"> Eliminar--}}
                    {{--activo</a>--}}
                    {{--@endcan--}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-calendar', 'bg' => 'bg-red'])
                @slot('title', 'Ultima vez reservado')
                @slot('number', '@{{fecha_reserva_activo}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Veces Reservado')
                @slot('number', '@{{veces_reservado}}')
            @endcomponent

            <input type="hidden" id="idActivo" value="{{$activo->id}}">
        </div>
    </div>
@endsection