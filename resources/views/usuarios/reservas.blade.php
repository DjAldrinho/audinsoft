@extends('layouts.layout')

@section('title', 'Mis Reservas')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Mis Reservas')

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
                                <td>Tipo de reserva</td>
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
                                    <td>
                                        <a href="{{route('ver-reserva', $reserva)}}" class="btn bg-purple btn-flat">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {!!$reservas->links()!!}
                </div>
                <div class="box-footer" align="center">
                    <a href="{{route('home')}}" class="btn btn-primary btn-flat btn-lg">
                        Reservar!
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
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-aqua-gradient'])
                @slot('title', 'Reservas de Audiovisuales')
                @slot('number', '@{{audiovisuales}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-teal-gradient'])
                @slot('title', 'Reservas de Infraestructura')
                @slot('number', '@{{infraestructura}}')
            @endcomponent

            @component('layouts.components.info-box',
 ['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-red-gradient'])
                @slot('title', 'Reservas de Bienestar Universitario')
                @slot('number', '@{{bienestar}}')
            @endcomponent
        </div>
    </div>

@endsection