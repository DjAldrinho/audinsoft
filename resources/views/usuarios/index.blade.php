@extends('layouts.layout')

@section('title', 'Gestionar Usuarios')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Gestionar Usuarios')

        Presione <code>ctrl + f</code> para buscar algun usuario

    @endcomponent

@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="box box-info">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Nombre</th>
                                <th>Codigo de usuario</th>
                                <th>Identificacion</th>
                                <th>Dependencia</th>
                                <th>Escuela</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>{{ucwords(Auth::user()->dependencia)}}</th>
                                <th></th>
                            </tr>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{$usuario->nombreCompleto}}</td>
                                    <td>{{$usuario->codigo_usuario or 'NA'}}</td>
                                    <td>{{$usuario->identificacion or 'NA'}}</td>
                                    <td>{{$usuario->dependencia or 'NA'}}</td>
                                    <td>{{$usuario->escuela or 'NA'}}</td>
                                    <td>{{$usuario->tipo}}</td>
                                    <td align="center">
                                        @if($usuario->estado == 'Activo')
                                            <span class="badge bg-green-active">{{str_replace("_", " ", $usuario->estado)}}</span>
                                        @else
                                            <span class="badge bg-red-active">{{str_replace("_", " ", $usuario->estado)}}</span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if(!$usuario->isBloqueado(ucwords(Auth::user()->dependencia)))
                                            <span class="badge bg-green-active">Activo</span>
                                        @else
                                            <span class="badge bg-red-active">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('ver-usuario', Crypt::encrypt($usuario->id))}}"
                                           class="btn btn-flat bg-purple"
                                           target="_blank">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {!!$usuarios->links()!!}
                </div>
            </div>
        </div>
    </div>
@endsection