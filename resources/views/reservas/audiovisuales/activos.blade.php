@extends('layouts.layout')

@section('title', 'Reservas audiovisuales')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Reservas audiovisuales')

        Recursos

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
            {!! Form::open(['route'=>['registro-reserva', 'audiovisuales', 'activos'],'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="box box-danger">
                <div class="box-body">
                    @include('layouts.includes.datos_usuario')
                    @include('layouts.includes.datos_reserva')
                    <h4>Datos del aula</h4>
                    <div class="form-group has-feedback{{ $errors->has('descripcion_aula') ? ' has-error' : '' }}">
                        <label for="txtAula" class="col-md-4 control-label">Descripcion del aula</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="descripcion_aula"
                                   value="{{old('descripcion_aula')}}" placeholder="Donde se ubicara el equipo"
                                   required>
                            @if($errors->has('descripcion_aula'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('descripcion_aula') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h4>Seleccionar equipos</h4>
                    <smal>Para buscar un equipo presione <code>ctrl + f</code></smal>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th width="20%">Nombre</th>
                                <th width="20%">Activos</th>
                                <th width="60%">Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($equipos as $equipo)
                                <tr>
                                    <td>{!! Form::radio('equipo', $equipo->id, false, ['class' => 'minimal-red']) !!}</td>
                                    <td>{{$equipo->nombre}}</td>
                                    <td>
                                        <table>
                                            @foreach($equipo->activos as $activo)
                                                <tr>
                                                    <td>- {{$activo->nombre}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>{{$equipo->descripcion or 'No Aplica'}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($errors->has('equipo'))
                            @component('layouts.components.callout', ['style' => 'warning'])
                                @slot('title', 'Error')
                                {{$errors->first('equipo')}}
                            @endcomponent
                        @endif
                    </div>
                    {{$equipos->links()}}
                    <hr>
                    <h4>Seleccionar activos extras</h4>
                    <smal>Para buscar un activo presione <code>ctrl + f</code></smal>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th width="20%">Nombre</th>
                                <th width="80%">Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activos as $activo)
                                @if(count($activo->equipos) == 0)
                                    <tr>
                                        <td>{!! Form::checkbox('activos[]', $activo->id, false, ['class' => 'minimal-red']) !!}</td>
                                        <td>{{$activo->nombre}}</td>
                                        <td>{{$activo->descripcion or 'No Aplica'}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        @if($errors->has('activos'))
                            @component('layouts.components.callout', ['style' => 'warning'])
                                @slot('title', 'Limite de activos por reserva')
                                {{$errors->first('activos')}}
                            @endcomponent
                        @endif
                    </div>
                    {{$activos->links()}}
                    <hr>
                    <h4>Terminos y Condiciones</h4>
                    <div class="well">
                        Al realizar una reserva, me hago responsable del uso adecuado del(os) equipo(s) y me
                        comprometo a hacerlos llegar a la oficina de Audiovisuales inmediatamente se cumpla
                        el
                        plazo de mi reserva. En caso de pérdida, daño o robo debo responder por su
                        reposición.
                        El solicitante debe acercarse a la oficina de Audiovisuales 10 minutos antes para la
                        puesta en marcha del equipo.
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
            {!! Form::hidden('tipo_reserva', 'audiovisuales', ['id' => 'tipo_reserva']) !!}
        </div>
    </div>
@endsection