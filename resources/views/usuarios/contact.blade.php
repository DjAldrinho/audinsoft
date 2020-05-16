@extends('layouts.layout')

@section('title', 'Contactar a '.$user->nombreCompleto)

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Usuarios')

        Enviar mensaje

    @endcomponent

@endsection


@section('content')
    <div class="row">

        <div class="col-md-10">

            @if(session('mensaje_error'))
                @component('layouts.components.callout', ['style' => 'danger'])

                    @slot('title', 'Error al enviar el mensaje')

                    {{session('mensaje_error')}}
                @endcomponent
            @endif

                @if(session('mensaje'))
                    @component('layouts.components.callout', ['style' => 'success'])

                        @slot('title', 'Mensaje enviado!')

                        {{session('mensaje')}}
                    @endcomponent
                @endif

            <div class="box box-primary">
                {!! Form::open(['route' => 'contactar-usuario']) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Enviar un nuevo mensaje</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <input class="form-control" placeholder="Para:" value="{{$user->email}}" readonly
                               name="email">
                    </div>
                    <div class="form-group">
                        <input class="form-control {{$errors->has('asunto')?'has-error':'l'}}" placeholder="Asunto:"
                               name="asunto" required>
                        @if($errors->has('asunto'))
                            <div class="help-block">
                                {{$errors->first('asunto')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{$errors->has('mensaje')?'has-error':''}}">
                        <textarea id="compose-textarea" class="form-control" style="height: 300px" name="mensaje"
                                  required></textarea>
                        @if($errors->has('mensaje'))
                            <div class="help-block">
                                {{$errors->first('mensaje')}}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-envelope-o"></i> Enviar
                        </button>
                    </div>
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
            </div>
            <!-- /. box -->
        </div>
    </div>
@endsection