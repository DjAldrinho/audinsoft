@component('mail::message')
# Su reserva de {{ucwords($reserva->tipo)}} ha cambiado de estado

Su reserva #{{$reserva->codigo_reserva}} realizada el dia {{$reserva->created_at->toFormattedDateString()}} para el dia {{$reserva->fecha_reserva->toFormattedDateString()}} de {{$reserva->hora_inicio}} a {{$reserva->hora_final}} ha sido {{ucwords($estado)}}


@if($estado == 'rechazada')

<b>Motivo de rechazo: </b> {{ucwords($motivo)}}

@endif

Para consultar mas detalles  de su reserva por favor inicie sesion

@component('mail::button', ['url' => route('login'), 'color' => 'red'])
  Iniciar Sesion
@endcomponent

Gracias por usar nuestra plataforma de reservas!,<br>
{{ config('app.name') }}
@endcomponent
