@extends('layouts.layout')

@section('title', 'Editar aula:  '.$aula->nombre)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Aulas')

        Editar datos del aula

    @endcomponent

@endsection


@section('content')
    <div class="row">
        <div class="col-md-8">
            {!! Form::open(['route'=>['editar-aula', $aula],'method' => 'put', 'class' => 'form-horizontal']) !!}
            <div class="box box-danger">
                <div class="box-body">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Nombre</label>
                        <div class="col-md-6">
                            <input id="id" type="text" class="form-control" value="{{$aula->nombre}}" name="nombre"
                                   required autofocus>
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Tipo</label>
                        <div class="col-md-6">
                            {!! Form::select('tipo', ['' => 'Seleccione una opcion','Aula' => 'Aula', 'Escenario deportivo' => 'Escenario deportivo', 'Laboratorio' => 'Laboratorio'], $aula->tipo, ['class' => 'form-control', 'required'])!!}
                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sede') ? ' has-error' : '' }}">
                        {!! Form::label('txtSede', 'Sede', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::select('sede', ['' => 'Seleccione una opcion','Coci' => 'Coci','Plaza Colon' => 'Plaza Colon', 'Santillana' => 'Santillana'], $aula->sede, ['class' => 'form-control', 'required'])!!}
                            @if ($errors->has('sede'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('sede') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        {!! Form::label('areaDescripcion', 'Descripcion', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::textArea('descripcion', $aula->descripcion, ['class' => 'form-control', 'rows' => '3']) !!}
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
                        {!! Form::submit('Actualizar Aula', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection