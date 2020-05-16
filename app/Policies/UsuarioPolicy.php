<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function before($user, $ability)
    {
        if ($user->superadministrador) {
            return true;
        }
    }

    public function action(User $user)
    {
        return $user->administrador && ($user->dependencia === 'Audiovisuales' || $user->dependencia === 'Infraestructura' || $user->dependencia === 'Bienestar Universitario');
    }
}
