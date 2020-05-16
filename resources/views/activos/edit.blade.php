@extends('layouts.layout')

@section('title', 'Editar activo:  '.$activo->nombre)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Activos')

        Editar datos del activo

    @endcomponent

@endsection


@section('content')
    <div class="row">
        <div class="col-md-8">
            {!! Form::open(['route' => ['editar-activo', $activo],'method' => 'put', 'class' => 'form-horizontal']) !!}
            <div class="box box-danger">
                <div class="box-body">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Nombre</label>
                        <div class="col-md-6">
                            <input id="id" type="text" class="form-control" value="{{$activo->nombre}}"
                                   name="nombre"
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
                                   value="{{$activo->marca}}"
                                   required autocomplete="off">
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
                            <input type="text" class="form-control" name="modelo" value="{{$activo->modelo}}"
                                   required>
                            @if ($errors->has('modelo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('modelo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    @if(isset($activo->serial))
                        <div class="form-group{{ $errors->has('serial') ? ' has-error' : '' }}">
                            <label for="txtSerial" class="col-md-4 control-label">Serial</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="serial" value="{{$activo->serial}}"
                                       id="txtSerial">
                                @if ($errors->has('serial'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="form-group{{ $errors->has('cantidad') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">Cantidad</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="cantidad"
                                       value="{{$activo->cantidad}}">
                                @if($errors->has('cantidad'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cantidad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Tipo</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control tipos-activos-typeahead" name="tipo"
                                   value="{{$activo->tipo}}" required
                                   autocomplete="off">
                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('dependencia') ? ' has-error' : '' }}">
                        {!! Form::label('txtDependencia', 'Dependencia', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::text('dependencia', $activo->dependencia, ['class' => 'form-control dependencia-typeahead', 'required', 'autocomplete' => 'off']) !!}
                            @if ($errors->has('dependencia'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dependencia') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        {!! Form::label('areaDescripcion', 'Descripcion', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::textArea('descripcion', $activo->descripcion, ['class' => 'form-control', 'rows' => '3']) !!}
                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-6 col-md-offset-4" align="right">
                        {!! Form::submit('Actualizar Activo', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection