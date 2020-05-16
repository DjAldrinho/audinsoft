@extends('layouts.layout')

@section('title', 'Reservas de aulas')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Reservas audiovisuales')

        Salas de sistemas

    @endcomponent

@endsection

@section('content')

    <div class="row" ng-app="reservas_module" ng-controller="reservasController" ng-cloak>
        <div class="col-md-8">
            @if(session('mensaje_error'))
                @component('layouts.components.alert', ['style' => 'warning', 'icon' => 'warning'])

                    @slot('title', 'No reservado!')

                    {{session('mensaje_error')}}
                @endcomponent
            @endif
            {!! Form::open(['route'=>['registro-reserva', 'infraestructura', 'salas'],'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="box box-danger">
                <div class="box-body">
                    @include('layouts.includes.datos_usuario')
                    @include('layouts.includes.datos_reserva')
                    <h4>Seleccionar aula</h4>
                    <smal>Para buscar un aula presione <code>ctrl + f</code></smal>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th width="20%">Nombre</th>
                                <th width="20%">Sede</th>
                                <th width="60%">Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($aulas as $aula)
                                <tr>
                                    <td>{!! Form::radio('aula', $aula->id, false, ['class' => 'minimal-red']) !!}</td>
                                    <td>{{$aula->nombre}}</td>
                                    <td>{{$aula->sede}}</td>
                                    <td>{{$aula->descripcion or 'No Aplica'}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($errors->has('aula'))
                        <span class="help-block">
                                        <p class="bg-danger">{{ $errors->first('aula') }}</p>
                                </span>
                    @endif
                    {{$aulas->links()}}
                    <hr>
                    <h4>Terminos y Condiciones</h4>
                    <div class="well">
                        Al realizar una reserva, me hago responsable del espacio solicitado, en caso de daño
                        por favor comunicarse inmediatamente con el area de infraestructura.
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit('Reservar!', ['class' => 'btn btn-success btn-lg btn-block']) !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            {!! Form::close() !!}
        </div>
        <div class="col-md-4">
            @component('layouts.components.info-box',
            ['progress' => false, 'icon'=> 'fa-star-o', 'bg' => '@{{bg_reservas_hoy}}'])
                @slot('title', 'Reservas para el dia de hoy')
                @slot('number') @{{ number_reservas_hoy }} @endslot
            @endcomponent

            @component('layouts.components.info-box',
         ['progress' => false, 'icon'=> 'fa-star-o', 'bg' => 'bg-navy'])
                @slot('title', 'Reservas en el mes actual')
                @slot('number') @{{ number_reservas_mes }} @endslot
            @endcomponent

            @component('layouts.components.info-box',
    ['progress' => false, 'icon'=> 'fa-star-o', 'bg' => 'bg-yellow'])
                @slot('title', 'Reservas en el año actual')
                @slot('number') @{{ number_reservas_ano }} @endslot
            @endcomponent
            {!! Form::hidden('tipo_reserva', 'infraestructura', ['id' => 'tipo_reserva']) !!}
        </div>
    </div>
@endsection