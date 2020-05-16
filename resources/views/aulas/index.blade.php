@extends('layouts.layout')

@section('title', 'Gestionar Aulas')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Gestionar Aulas')

        Presione <code>ctrl + f</code> para buscar algun aula

    @endcomponent

@endsection

@section('content')

    <div class="row" ng-app="gestionar_module" ng-controller="gestionarAulasController" ng-cloak>
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
                                <td>Nombre</td>
                                <td>Tipo</td>
                                <td>Sede</td>
                                <td>Creado</td>
                                <td>Actualizado</td>
                                <td>Estado</td>
                                <td></td>
                            </tr>
                            @foreach($aulas as $aula)
                                <tr>
                                    <td>{{$aula->nombre}}</td>
                                    <td>{{$aula->tipo}}</td>
                                    <td>{{$aula->sede}}</td>
                                    <td>{{$aula->created_at->diffForHumans()}}</td>
                                    <td>{{$aula->updated_at->diffForHumans()}}</td>
                                    <td>
                                        @if($aula->estado == 'Disponible')
                                            <span class="badge bg-green-active">{{str_replace("_", " ", $aula->estado)}}</span>
                                        @elseif($aula->estado == 'Ocupado')
                                            <span class="badge bg-red-active">{{str_replace("_", " ", $aula->estado)}}</span>
                                        @elseif($aula->estado == 'Mantenimiento')
                                            <span class="badge bg-yellow-active">{{str_replace("_", " ", $aula->estado)}}</span>
                                        @else
                                            <span class="badge bg-navy-active">{{str_replace("_", " ", $aula->estado)}}</span>
                                        @endif
                                    </td>
                                    @can('modify',$aula)
                                        <td><a href="{{route('ver-aula', $aula)}}" class="btn bg-purple btn-flat"
                                               target="_blank">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </a></td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {!!$aulas->links()!!}
                </div>
                <div class="box-footer" align="center">
                    <a href="{{route('registro-aula')}}" class="btn btn-app">
                        <i class="fa fa-plus-circle"></i>
                        Añadir aula
                    </a>
                    <a href="{{route('reporte-aulas')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte de Aulas
                    </a>
                    <a href="{{route('reporte-general-aulas')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte general
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Cantidad de Aulas')
                @slot('number', $aulas->total())
            @endcomponent

            @component('layouts.components.info-box',
         ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Aulas disponibles')
                @slot('number', '@{{disponibles}}')
            @endcomponent

            @component('layouts.components.info-box',
    ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Aulas Ocupadas')
                @slot('number', '@{{ocupados}}')
            @endcomponent

            @component('layouts.components.info-box',
           ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Aulas en mantenimiento')
                @slot('number', '@{{mantenimiento}}')
            @endcomponent

            @component('layouts.components.info-box',
      ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Aulas pendientes por reserva')
                @slot('number', '@{{pendientes}}')
            @endcomponent
        </div>
    </div>

@endsection