@component('mail::message')
# Se ha registrado una reserva

El usuario {{$reserva->usuario->nombreCompleto}} ha realizado una reserva el dia {{$reserva->created_at->format('d/m/Y')}}

<b>Fecha reserva: </b> {{$reserva->fecha_reserva->format('d/m/Y')}} de {{$reserva->hora_inicio->format('h:i a')}} hasta las {{$reserva->hora_final->format('h:i a')}}

El # de la reserva es <b><i>{{$reserva->codigo_reserva}}</i></b>

Por favor ingrese a la plataforma para ver la lista de reservas

@component('mail::button', ['url' => route('listar-reservas'), 'color' => 'red'])
lista de reservas
@endcomponent


@endcomponent
