@extends('layouts.layout')

@section('title', 'Registro de activos')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Activos')

        Registro

    @endcomponent

@endsection


@section('content')
    <div class="row" ng-app>
        <div class="col-md-8">
            {!! Form::open(['route'=>'registro-activo','method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="box box-success">
                <div class="box-body">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Nombre</label>
                        <div class="col-md-6">
                            <input id="id" type="text" class="form-control" value="{{old('nombre')}}" name="nombre"
                                   required autofocus>
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('marca') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Marca</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control marcas-activos-typeahead" name="marca"
                                   value="{{old('marca')}}" required autocomplete="off">
                            @if ($errors->has('marca'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('marca') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('modelo') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Modelo</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="modelo" value="{{old('modelo')}}"
                                   required>
                            @if ($errors->has('modelo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('modelo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('has_serial') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Tiene serial?</label>
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('has_serial', old('has_serial'), false, ['id' => 'checkSerial', 'ng-model' => 'checked']) !!}
                                </label>
                            </div>
                            @if ($errors->has('has_serial'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('has_serial') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('serial') ? ' has-error' : '' }}">
                        <label for="txtSerial" class="col-md-4 control-label">Serial</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="serial" value="{{old('serial')}}"
                                   ng-disabled="!checked" id="txtSerial">
                            @if ($errors->has('serial'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('serial') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('cantidad') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Cantidad</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="cantidad" value="{{old('cantidad')}}"
                                   ng-disabled="checked">
                            @if ($errors->has('cantidad'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('cantidad') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Tipo</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control tipos-activos-typeahead" name="tipo"
                                   value="{{old('tipo')}}" required
                                   autocomplete="off">
                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->superadministrador)
                        <div class="form-group{{ $errors->has('dependencia') ? ' has-error' : '' }}">
                            {!! Form::label('txtDependencia', 'Dependencia', ['class' => 'col-md-4 control-label']); !!}
                            <div class="col-md-6">
                                {!! Form::text('dependencia', old('dependencia'), ['class' => 'form-control dependencia-typeahead', 'required', 'autocomplete' => 'off']) !!}
                                @if ($errors->has('dependencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dependencia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="form-group{{ $errors->has('dependencia') ? ' has-error' : '' }}">
                            {!! Form::label('txtDependencia', 'Dependencia', ['class' => 'col-md-4 control-label']); !!}
                            <div class="col-md-6">
                                {!! Form::text('dependencia', Auth::user()->dependencia, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'readonly']) !!}
                                @if ($errors->has('dependencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dependencia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->superadministrador || Auth::user()->dependencia == 'Bienestar Universitario' )
                        <div class="form-group{{ $errors->has('grupo') ? ' has-error' : '' }}">
                            {!! Form::label('selectGrupo', 'Grupo', ['class' => 'col-md-4 control-label']); !!}
                            <div class="col-md-6">
                                {!! Form::select('grupo', ['' => 'Seleccione una opcion','Deportivos', 'Culturales'],old('grupo'), ['class' => 'form-control', !Auth::user()->superadministrador?'required':'']) !!}
                                @if ($errors->has('grupo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('grupo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        {!! Form::label('areaDescripcion', 'Descripcion', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::textArea('descripcion', old('descripcion'), ['class' => 'form-control', 'rows' => '3']) !!}
                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer" align="right">
                    {!! Form::submit('Registrar Activo', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection