@extends('layouts.layout')

@section('title', 'Pagina Principal')

@section('content-header')

    @component('layouts.components.content-header')

        @slot('page_header', 'Principal')

        Reservar

    @endcomponent

@endsection

@section('content')
    <fieldset>
        <legend>Audiovisuales</legend>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Recursos audiovisuales</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="thumbnail">
                            <img src="{{asset('images/audiovisuales.jpg')}}" alt="Reservar recursos audiovisuales">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                        <p>Reserva ordernadores, videobeams, cables, entre otros.</p>
                        <a href=""></a>
                        <a href="{{route('reservar-audiovisuales', ['activos'])}}"
                           class="btn btn-danger btn-flat pull-right"
                           role="button">
                            Reservar
                            <i class="fa fa-arrow-circle-o-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Salas de sitemas</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="thumbnail">
                            <img src="{{asset('images/aulas.jpg')}}" alt="Reservar salas de sistemas">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                        <p>Reserva las salas de sistemas</p>
                        <a href=""></a>
                        <a href="{{route('reservar-audiovisuales', ['salas'])}}"
                           class="btn btn-danger btn-flat pull-right"
                           role="button">
                            Reservar
                            <i class="fa fa-arrow-circle-o-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Bienestar universitario</legend>
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Escenarios deportivos</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="thumbnail">
                        <img src="{{asset('images/deportivos.jpg')}}" alt="Reservar escenarios deportivos">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <p>Canchas de microfutbol/baloncesto, tenis y futbol</p>
                    <a href=""></a>
                    <a href="{{route('reservar-deportivos')}}" class="btn btn-danger btn-flat pull-right"
                       role="button">
                        Reservar
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Instrumentos deportivos</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="thumbnail">
                        <img src="{{asset('images/deportivos.jpg')}}" alt="Reservar escenarios deportivos">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <p>Canchas de microfutbol/baloncesto, tenis y futbol</p>
                    <a href=""></a>
                    <a href="{{route('reservar-deportivos')}}" class="btn btn-danger btn-flat pull-right"
                       role="button">
                        Reservar
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Instrumentos culturales</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="thumbnail">
                        <img src="{{asset('images/deportivos.jpg')}}" alt="Reservar escenarios deportivos">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <p>Canchas de microfutbol/baloncesto, tenis y futbol</p>
                    <a href=""></a>
                    <a href="{{route('reservar-deportivos')}}" class="btn btn-danger btn-flat pull-right"
                       role="button">
                        Reservar
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Infraestructura</legend>
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Aulas y Laboratorios</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="thumbnail">
                        <img src="{{asset('images/aulas.jpg')}}" alt="Reservar aulas y laboratorios">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <p>Canchas de microfutbol/baloncesto, tenis y futbol</p>
                    <a href=""></a>
                    <a href="{{route('reservar-aulas')}}" class="btn btn-danger btn-flat pull-right"
                       role="button">
                        Reservar
                        <i class="fa fa-arrow-circle-o-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </fieldset>
@endsection