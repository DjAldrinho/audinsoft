@component('mail::message')
# Se ha registrado su reserva

Reserva creada el dia {{$reserva->created_at->format('d/m/Y')}} para el dia {{$reserva->fecha_reserva->format('d/m/Y')}}
de {{$reserva->hora_inicio->format('h:i a')}} hasta las {{$reserva->hora_final->format('h:i a')}}

Su reserva de {{$reserva->tipo}} #{{$reserva->codigo_reserva}} ha sido creada correctamente!

Por favor ingrese a la plataforma para comprobar el estado de su reserva

@component('mail::button', ['url' => route('mis-reservas'), 'color' => 'red'])
Ver reservas
@endcomponent

Gracias por utilizar nuestra plataforma {{ config('app.name') }}
@endcomponent

