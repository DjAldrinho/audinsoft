@component('mail::message')
# Registro con exito!

Su usuario ha sido registrado correctamente!

Para empezar a realizar reservas, por favor ingrese al siguiente enlace

@component('mail::button', ['url' => route('login'), 'color' => 'red'])
Iniciar Sesion
@endcomponent

Gracias por utilizar nuestra plataforma,<br>
Equipo de {{ config('app.name') }}
@endcomponent
