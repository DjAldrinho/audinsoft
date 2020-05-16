<?php

namespace App\Policies;

use App\User;
use App\Activo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivoPolicy
{
    use HandlesAuthorization;


    public function before($user, $ability)
    {
        if ($user->superadministrador) {
            return true;
        }
    }

    /**
     * Determine whether the user can create activos.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function action(User $user)
    {
        return $user->rol == 'Administrativo' && $user->administrador;
    }


    /**
     * Determine whether the user can view the activo.
     *
     * @param  \App\User $user
     * @param  \App\Activo $activo
     * @return mixed
     */
    public function modify(User $user, Activo $activo)
    {
        return $user->rol == 'Administrativo' && $user->dependencia == $activo->dependencia && $user->administrador;
    }


    public function addEquipo(User $user)
    {
        return $user->dependencia == 'Servicios Audiovisuales';
    }

    /**
     * Determine whether the user can delete the activo.
     *
     * @param  \App\User $user
     * @param  \App\Activo $activo
     * @return mixed
     */
    public function delete(User $user, Activo $activo)
    {

    }


}
