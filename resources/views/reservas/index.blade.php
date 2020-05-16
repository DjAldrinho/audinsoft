@extends('layouts.layout')

@section('title', 'Gestionar Reservas')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Gestionar reservas')

        Presione <code>ctrl + f</code> para buscar alguna reserva

    @endcomponent

@endsection

@section('content')

    <div class="row" ng-app="gestionar_module" ng-controller="gestionarReservasController" ng-cloak>
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
                                <td>Codigo</td>
                                <td>Fecha</td>
                                <td>Hora Inicio</td>
                                <td>Hora Final</td>
                                <td>Activos</td>
                                <td>Aula</td>
                                <td class="{{!Auth::user()->superadministrador?'hidden':''}}">Tipo de reserva</td>
                                <td>Estado</td>
                                <td></td>
                            </tr>
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td>{{$reserva->codigo_reserva}}</td>
                                    <td>{{$reserva->fecha_reserva->format('d/m/Y')}}</td>
                                    <td>{{$reserva->hora_inicio}}</td>
                                    <td>{{$reserva->hora_final}}</td>
                                    <td>{{count($reserva->activos)}}</td>
                                    <td>{{$reserva->aula->nombre or 'NA'}}</td>
                                    <td class="{{!Auth::user()->superadministrador?'hidden':''}}">{{ucwords($reserva->tipo)}}</td>
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
                                    @can('view',$reserva)
                                        <td>
                                            <a href="{{route('ver-reserva', $reserva)}}" class="btn bg-purple btn-flat"
                                               target="_blank">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {!!$reservas->links()!!}
                </div>
                <div class="box-footer" align="center">
                    <a href="{{route('home')}}" class="btn btn-app">
                        <i class="fa fa-plus-circle"></i>
                        Realizar una reserva!
                    </a>
                    <a href="{{route('reporte-reservas')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte de Reservas
                    </a>
                    <a href="{{route('reporte-general-reservas')}}" class="btn btn-app" target="_blank">
                        <i class="fa fa-newspaper-o"></i>
                        Reporte general
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Cantidad de Reservas')
                @slot('number', $reservas->total())
            @endcomponent

            @component('layouts.components.info-box',
      ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas activas')
                @slot('number', '@{{activas}}')
            @endcomponent

            @component('layouts.components.info-box',
         ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas Finalizadas')
                @slot('number', '@{{finalizadas}}')
            @endcomponent

            @component('layouts.components.info-box',
    ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas Pendientes')
                @slot('number', '@{{pendientes}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas Aprobadas')
                @slot('number', '@{{aprobadas}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas Rechazadas')
                @slot('number', '@{{rechazadas}}')
            @endcomponent
        </div>
    </div>

@endsection