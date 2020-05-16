<?php

namespace App\Policies;

use App\User;
use App\Reserva;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservaPolicy
{
    use HandlesAuthorization;


    public function before($user, $ability)
    {
        if ($user->superadministrador) {
            return true;
        }
    }


    public function action(User $user)
    {
        return $user->tipo == 'Administrativo' && $user->dependencia != null && $user->administrador;
    }

    public function view(User $user, Reserva $reserva)
    {
        return (ucwords($user->dependencia) == ucwords($reserva->tipo) && $user->administrador) || $user->id == $reserva->usuario->id;
    }

    public function modify(User $user, Reserva $reserva)
    {
        return ucwords($user->dependencia) == ucwords($reserva->tipo) && $user->administrador;
    }

}
