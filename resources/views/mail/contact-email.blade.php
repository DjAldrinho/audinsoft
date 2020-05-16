@component('mail::message')
# El usuario {{Auth::user()->nombreCompleto}} le ha enviado un correo

<b>Fecha: </b> {{\Carbon\Carbon::now()->format('d/m/Y')}}

<b>Mensaje</b>

{!! $contacto['mensaje'] !!}

Gracias por utilizar nuestra plataforma {{ config('app.name') }}
@endcomponent

