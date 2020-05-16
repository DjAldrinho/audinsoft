@component('mail::message')

# Su usuario ha sido {{$estado}}


Su usuario {{$baneado->usuario->email}} ha sido {{$estado}} para realizar reservas de {{$baneado->responsable}} el dia {{$baneado->created_at->format('d/m/Y')}}

@if($estado == 'baneado')
  Por el <b>motivo</b> de: {{$baneado->motivo}} <br/>
  Si tiene algun reclamo, por favor acerquese a la oficina de {{$baneado->responsable}}
@else
   Por favor ingrese a la plataforma, si desea realizar una reserva!
   @component('mail::button', ['url' => route('login'), 'color' => 'red'])
       Iniciar Sesion
   @endcomponent
@endif

Gracias por utilizar nuestra plataforma {{ config('app.name') }}
@endcomponent