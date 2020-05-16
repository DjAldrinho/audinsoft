<?php

namespace App\Providers;

use App\Activo;
use App\Aula;
use App\Policies\ActivoPolicy;
use App\Policies\AulaPolicy;
use App\Policies\ReservaPolicy;
use App\Policies\UsuarioPolicy;
use App\Reserva;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        Activo::class => ActivoPolicy::class,
        Aula::class => AulaPolicy::class,
        User::class => UsuarioPolicy::class,
        Reserva::class => ReservaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
