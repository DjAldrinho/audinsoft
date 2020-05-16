@extends('layouts.layout')

@section('title', 'Detalles de '.$equipo->nombre)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Equipos')

        Detalles del equipo

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
                                <td>{{$equipo->nombre}}</td>
                            </tr>
                            <tr>
                                <td><b>Creado</b></td>
                                <td>{{ucwords($equipo->created_at->toDayDateTimeString())}}</td>
                            </tr>
                            @if($equipo->created_at->toDayDateTimeString() != $equipo->updated_at->toDayDateTimeString())
                                <tr>
                                    <td><b>Ultima Modificacion</b></td>
                                    <td>{{ucwords($equipo->updated_at->toDayDateTimeString())}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Estado</b></td>
                                <td>{{str_replace("_", " ", $equipo->estado)}}</td>
                            </tr>
                            <tr>
                                <td><b>Activos</b></td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="20%"></th>
                                            <th></th>
                                        </tr>
                                        @foreach($equipo->activos as $activo)
                                            <tr>
                                                <td>- {{$activo->nombre}}</td>
                                                <td ><a href="{{route('ver-activo', $activo)}}"
                                                       class="btn bg-purple btn-xs">
                                                        <i class="glyphicon glyphicon-search"></i>
                                                    </a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    @can('addEquipo',App\Activo::class)
                        <a href="{{route('editar-equipo', $equipo)}}" class="btn btn-flat btn-primary">
                            <i class="fa fa-pencil"></i> Editar equipo
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

            <input type="hidden" id="idActivo" value="{{$equipo->id}}">
        </div>
    </div>
@endsection