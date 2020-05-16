<?php

namespace App;

use App\Events\NewUserEvent;
use App\Traits\DatesTranslator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, DatesTranslator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'codigo_usuario',
        'identificacion',
        'telefono',
        'dependencia',
        'escuela',
        'semestre',
        'cargo',
        'administrador',
        'jornada',
        'rol',
        'estado',
        'superadministrador',
        'email',
        'password',
    ];


    protected $events = [
        'created' => NewUserEvent::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     *  Relaciones
     *
     */

    public function bloqueos()
    {
        return $this->hasMany('App\Baneado', 'usuario_id');
    }

    public function reservas()
    {
        return $this->hasMany('App\Reserva', 'usuario_id');
    }

    /**
     *
     * Mutators
     */


    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    /**
     * @param $responsable
     * @return bool
     */
    public function isBloqueado($responsable)
    {
        $bloqueo = false;

        foreach ($this->bloqueos as $bloqueo) {
            if ($bloqueo->responsable === $responsable && $bloqueo->actual) {
                $bloqueo = true;
            } else {
                $bloqueo = false;
            }
        }
        return $bloqueo;
    }

    /**
     *  Funciones
     */
    public static function findUserByIdentificacion($identificacion)
    {
        return self::where('identificacion', '=', $identificacion)->first();
    }

    /**
     * @param $codigo_usuario
     * @return mixed
     */
    public static function findUserByCodigoUsuario($codigo_usuario)
    {
        return self::where('codigo_usuario', '=', $codigo_usuario)->first();
    }

    /**
     * @param $identificacion
     * @return bool
     */
    public static function existByIdentificacion($identificacion)
    {
        return self::where('identificacion', '=', $identificacion)->exists();
    }

    /*
     * Existe usuario por codigo
     */

    public static function existByCodigoUsuario($codigo_usuario)
    {
        return self::where('codigo_usuario', '=', $codigo_usuario)->exists();
    }


    /*
     * Listar Escuelas
     */

    public function scopeEscuelas()
    {
        return self::select(['escuela'])
            ->distinct();
    }

    /*
     * Listar Dependencias
     */
    public function scopeDependencias()
    {
        return self::select(['dependencia'])
            ->distinct();
    }

    /*
     * Buscar por nombre
     */

    public function scopeByNombre($query, $campo, $valor)
    {
        return $query->where($campo, 'like', '%' . $valor . '%');
    }

    /*
     *  Buscar Por dependencia
     */

    /**
     * @param $query
     * @param $dependencia
     * @return mixed
     */
    public function scopeByDependencia($query, $dependencia)
    {
        return $query->where('dependencia', '=', $dependencia);
    }

    /*
     * Campo no nulo
     */

    /**
     * @param $query
     * @param $campo
     * @return mixed
     */
    public function scopeNotNull($query, $campo)
    {
        return $query->where($campo, '!=', null);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAdministradores($query)
    {
        return $query->where('administrador', '=', true);
    }


}
