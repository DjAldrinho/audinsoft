@extends('layouts.layout')

@section('title', 'Registro de aulas')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Aulas')

        Registro

    @endcomponent

@endsection


@section('content')
    <div class="row">
        <div class="col-md-8">
            {!! Form::open(['route'=>'registro-aula','method' => 'post', 'class' => 'form-horizontal']) !!}
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
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Tipo</label>
                        <div class="col-md-6">
                            {!! Form::select('tipo',
                            ['' => 'Seleccione una opcion',
                            'Aula' => 'Aula', 'Auditorios' =>
                            'Auditorios' ,'Escenario deportivo' =>
                            'Escenario deportivo',
                            'Escenario cultural' =>
                            'Escenario cultural',
                            'Laboratorio' => 'Laboratorio',
                            'Salas de juntas' => 'Salas de juntas',
                            'Salas de sistemas' => 'Salas de sistemas'], old('tipo'), ['class' => 'form-control', 'required'])!!}
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
                            {!! Form::select('sede', ['' => 'Seleccione una opcion','Coci' => 'Coci','Plaza Colon' => 'Plaza Colon', 'Santillana' => 'Santillana'], old('sede'), ['class' => 'form-control', 'required'])!!}
                            @if ($errors->has('sede'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('sede') }}</strong>
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
                    <div class="form-group{{ $errors->has('capacidad') ? ' has-error' : '' }}">
                        {!! Form::label('numberCapacidad', 'Capacidad', ['class' => 'col-md-4 control-label']); !!}
                        <div class="col-md-6">
                            {!! Form::number('capacidad', old('capacidad'), ['class' => 'form-control', 'required', 'min' => '1' ,'step' => '1', 'pattern' => '^[0-9]', 'title' => 'Solo numeros']) !!}
                            @if ($errors->has('capacidad'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('capacidad') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
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
                    {!! Form::submit('Registrar Aula', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection