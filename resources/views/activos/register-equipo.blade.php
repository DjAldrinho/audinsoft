@extends('layouts.layout')

@section('title', 'Registro de equipos')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Activos')

        Registro de equipos

    @endcomponent

@endsection


@section('content')
    <div class="row" ng-app>
        <div class="col-md-8">
            {!! Form::open(['route'=>'registro-equipo','method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="box box-success">
                <div class="box-body">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-2 control-label">Nombre</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="{{old('nombre')}}" name="nombre"
                                   required autofocus placeholder="Nombre del equipo">
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Activos</label>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Cantidad</th>
                                        <th>Descripcion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activos as $activo)
                                        <tr>
                                            <td>{!! Form::checkbox('activos[]', $activo->id, false, ['class' => 'minimal-red']) !!}</td>
                                            <td>{{$activo->nombre}}</td>
                                            <td>{{$activo->marca}}</td>
                                            <td>{{$activo->cantidad>1?$activo->cantidad:1}}</td>
                                            <td>{{$activo->descripcion or 'No Aplica'}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($errors->has('activos'))
                                    @component('layouts.components.callout', ['style' => 'warning'])
                                        @slot('title', 'Error!')
                                        {{$errors->first('activos')}}
                                    @endcomponent
                                @endif
                            </div>
                            {{$activos->links()}}
                        </div>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    {!! Form::submit('Registrar equipo', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection