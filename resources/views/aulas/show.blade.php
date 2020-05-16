@extends('layouts.layout')

@section('title', 'Detalles de '.$aula->nombre)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Aulas')

        Detalles del aula

    @endcomponent

@endsection


@section('content')

    <div class="row" ng-app="gestionar_module" ng-controller="gestionarAulasController" ng-cloak>
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
                                <td>{{$aula->nombre}}</td>
                            </tr>
                            <tr>
                                <td><b>Sede</b></td>
                                <td>{{$aula->sede}}</td>
                            </tr>
                            <tr>
                                <td><b>Tipo</b></td>
                                <td>{{$aula->tipo}}</td>
                            </tr>
                            <tr>
                                <td><b>Creado</b></td>
                                <td>{{ucwords($aula->created_at->toDayDateTimeString())}}</td>
                            </tr>
                            @if($aula->created_at->toDayDateTimeString() != $aula->updated_at->toDayDateTimeString())
                                <tr>
                                    <td width="30%"><b>Ultima Modificacion</b></td>
                                    <td>{{ucwords($aula->updated_at->toDayDateTimeString())}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Estado</b></td>
                                <td>{{$aula->estado}}</td>
                            </tr>
                            <tr>
                                <td><b>Descripcion</b></td>
                                <td>{{$aula->descripcion or 'NA'}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    @can('modify',$aula)
                        <a href="{{route('editar-aula', $aula)}}" class="btn btn-primary btn-flat">
                            <i class="fa fa-pencil"></i>
                            Editar Aula
                        </a>
                    @endcan
                    {{--@can('delete', $aula)--}}
                    {{--<a href="{{route('eliminar-aula', $aula)}}" class="btn btn-danger"> Eliminar--}}
                    {{--Aula</a>--}}
                    {{--@endcan--}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-calendar', 'bg' => 'bg-red'])
                @slot('title', 'Ultima vez reservada')
                @slot('number', '@{{fecha_reserva_activo}}')
            @endcomponent

            @component('layouts.components.info-box',
['progress' => false, 'icon'=> 'fa-info-circle', 'bg' => 'bg-navy'])
                @slot('title', 'Veces Reservada')
                @slot('number', '@{{veces_reservado}}')
            @endcomponent

            <input type="hidden" id="idAula" value="{{$aula->id}}">
        </div>
    </div>
@endsection