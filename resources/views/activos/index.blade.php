@extends('layouts.layout')

@section('title', 'Gestionar activos')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Gestionar activos')

        Presione <code>ctrl + f</code> para buscar algun activo

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
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serial</th>
                                <th>Cantidad</th>
                                <th>Actualizado</th>
                                <th class="{{!Auth::user()->superadministrador?'hidden':''}}">Dependencia</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            @foreach($activos as $activo)
                                <tr>
                                    <td>{{$activo->nombre}}</td>
                                    <td>{{$activo->marca}}</td>
                                    <td>{{$activo->modelo}}</td>
                                    <td>{{$activo->serial or 'NA'}}</td>
                                    <td>{{$activo->cantidad or 1}}</td>
                                    <td>{{$activo->updated_at->diffForHumans()}}</td>
                                    <td class="{{!Auth::user()->superadministrador?'hidden':''}}">{{$activo->dependencia}}</td>
                                    <td>
                                        @if($activo->estado == 'Disponible')
                                            <span class="badge bg-green-active">{{str_replace("_", " ", $activo->estado)}}</span>
                                        @elseif($activo->estado == 'Ocupado')
                                            <span class="badge bg-red-active">{{str_replace("_", " ", $activo->estado)}}</span>
                                        @elseif($activo->estado == 'Mantenimiento')
                                            <span class="badge bg-yellow-active">{{str_replace("_", " ", $activo->estado)}}</span>
                                        @else
                                            <span class="badge bg-navy-active">{{str_replace("_", " ", $activo->estado)}}</span>
                                        @endif
                                    </td>
                                    @can('modify',$activo)
                                        <td><a href="{{route('ver-activo', $activo)}}" class="btn bg-purple btn-xse"
                                               target="_blank">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </a></td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$activos->links()}}
                </div>
                <!-- /.box-body -->
                <div class="box-footer" align="center">
                    @can('addEquipo',App\Activo::class)
                        <a href="{{route('registro-equipo')}}" class="btn btn-app">
                            <i class="fa fa-plus-circle"></i>
                            Añadir equipo
                        </a>
                        <a href="{{route('listar-equipos')}}" class="btn btn-app">
                            <i class="fa fa-eye"></i>
                            Listar Equipos
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

            @component('layouts.components.small-box', ['bg' => 'bg-red', 'icon' => 'flag'])

                @slot('title', 'Activo mas reservado: @{{nombre_activo_reservado}}')

                @slot('number', '@{{frecuencia_activo_reservado}}')

            @endcomponent

            @component('layouts.components.small-box', ['bg' => 'bg-red', 'icon' => 'flag'])

                @slot('title', 'Tipo de activo mas reservado: @{{nombre_tipo_activo_reservado}}')

                @slot('number', '@{{frecuencia_tipo_activo_reservado}}')


            @endcomponent

            @component('layouts.components.info-box',
        ['progress' => false, 'icon'=> 'fa-bell-o', 'bg' => 'bg-yellow'])
                @slot('title', 'Activos por agotarse')
                @slot('number')
                    <span ng-repeat="activo in activos">@{{activo.nombre}}@{{$last ? '' : ', '}}</span>
                @endslot
            @endcomponent


            @component('layouts.components.info-box',
    ['progress' => false, 'icon'=> 'fa-bell-o', 'bg' => 'bg-yellow'])
                @slot('title')
                    Activo con mas inventario: <b>@{{activo.nombre}}</b>
                @endslot
                @slot('number', '@{{activo.cantidad}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Cantidad de Activos')
                @slot('number', $activos->total())
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
                @slot('title', 'Activos en mantenimiento')
                @slot('number', '@{{mantenimiento}}')
            @endcomponent

            @component('layouts.components.info-box',
      ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Activos pendientes por reserva')
                @slot('number', '@{{pendientes}}')
            @endcomponent

            @component('layouts.components.info-box',
         ['progress' => false, 'icon'=> 'fa-thumbs-o-up', 'bg' => 'bg-green'])
                @slot('title', 'Marcas Populares')
                @slot('number')
                    <span ng-repeat="marca in marcas">@{{marca.marca}}@{{$last ? '' : ', '}}</span>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection