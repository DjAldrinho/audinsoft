<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe general de activos - {{$date}}</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-container w3-center w3-light-grey">
    <img src="http://calidad.unisinucartagena.edu.co:8010/CalidadOnline/public/images/logo_unisinu_rojo.png" alt="logo"
         class="w3-round w3-image w3-padding-16"/>
</div>
<div class="w3-container w3-center">
    <h3>Informe general de activos del dia {{$date}}</h3>

    <table class="w3-table-all w3-small">
        <thead>
        <tr class="w3-red">
            <th>Informe</th>
            <th></th>
            <th>Frecuencia</th>
        </tr>
        </thead>
        <tr>
            <td>Activo mas reservado</td>
            <td>{{isset($activo_popular)?ucwords($activo_popular->nombre):'Ninguno'}}</td>
            <td>{{isset($activo_popular)?$activo_popular->frecuencia:''}}</td>
        </tr>
        <tr>
            <td>Tipo de activo mas reservado</td>
            <td>{{isset($tipo_activo)?ucwords($tipo_activo->tipo):'Ninguno'}}</td>
            <td>{{isset($tipo_activo)?$tipo_activo->frecuencia:''}}</td>
        </tr>
        <tr>
            <td>Cantidad de activos</td>
            <td></td>
            <td>{{$total_activos}}</td>
        </tr>
        <tr>
            <td>Activos disponibles</td>
            <td></td>
            <td>{{$disponibles}}</td>
        </tr>
        <tr>
            <td>Activos ocupados</td>
            <td></td>
            <td>{{$ocupados}}</td>
        </tr>
        <tr>
            <td>Activos pendientes por reserva</td>
            <td></td>
            <td>{{$pendientes}}</td>
        </tr>
        <tr>
            <td>Activos en mantenimiento</td>
            <td></td>
            <td>{{$mantenimiento}}</td>
        </tr>
    </table>
</div>
</body>
</html>