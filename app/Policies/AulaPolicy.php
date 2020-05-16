<?php

namespace App\Policies;

use App\Aula;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AulaPolicy
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
        return $user->administrador;
    }

    public function modify(User $user, Aula $aula)
    {
        return $user->administrador && $user->dependencia == $aula->dependencia;
    }


}
