@extends('layouts.layout')

@section('title', 'Gestionar equipos')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Gestionar equipos')

        Presione <code>ctrl + f</code> para buscar algun equipo

    @endcomponent

@endsection

@section('content')

    <div class="row" ng-app="gestionar_module" ng-controller="gestionarActivosController" ng-cloak>
        <div class="col-md-8">
            @if(session('mensaje'))
                @component('layouts.components.callout', ['style' => 'success'])

                    @slot('title', 'Exito!')

                    {{session('mensaje')}}

                @endcomponent
            @endif
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Nombre</th>
                                <th>Activos</th>
                                <th>Actualizado</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            @foreach($equipos as $equipo)
                                <tr>
                                    <td>{{$equipo->nombre}}</td>
                                    <td>{{count($equipo->activos)}}</td>
                                    <td>{{$equipo->updated_at->diffForHumans()}}</td>
                                    <td>
                                        @if($equipo->estado == 'Disponible')
                                            <span class="badge bg-green-active">{{str_replace("_", " ", $equipo->estado)}}</span>
                                        @elseif($equipo->estado == 'Ocupado')
                                            <span class="badge bg-red-active">{{str_replace("_", " ", $equipo->estado)}}</span>
                                        @elseif($equipo->estado == 'Mantenimiento')
                                            <span class="badge bg-yellow-active">{{str_replace("_", " ", $equipo->estado)}}</span>
                                        @else
                                            <span class="badge bg-navy-active">{{str_replace("_", " ", $equipo->estado)}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('ver-equipo', $equipo)}}" class="btn bg-purple">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$equipos->links()}}
                </div>
                <!-- /.box-body -->
                <div class="box-footer" align="center">
                    @can('addEquipo',App\Activo::class)
                        <a href="{{route('registro-equipo')}}" class="btn btn-app">
                            <i class="fa fa-plus-circle"></i>
                            Añadir equipo
                        </a>
                        <a href="{{route('listar-activos')}}" class="btn btn-app">
                            <i class="fa fa-eye"></i>
                            Listar Activos
                        </a>
                    @endcan
                    <a href="{{route('registro-activo')}}" class="btn btn-app">
                        <i class="fa fa-plus-circle"></i>
                        Añadir Activo
                    </a>
                    <a href="{{route('reporte-activos')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte de Activos
                    </a>
                    <a href="{{route('reporte-general-activos')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte general
                    </a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Cantidad de Activos')
                @slot('number', $equipos->total())
            @endcomponent

            @component('layouts.components.info-box',
         ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Activos disponibles')
                @slot('number', '@{{disponibles}}')
            @endcomponent

            @component('layouts.components.info-box',
    ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Activos Ocupados')
                @slot('number', '@{{ocupados}}')
            @endcomponent

            @component('layouts.components.info-box',
      ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Activos pendientes por reserva')
                @slot('number', '@{{pendientes}}')
            @endcomponent
        </div>
    </div>
@endsection