<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{

    use DatesTranslator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'marca',
        'modelo',
        'serial',
        'manual',
        'cantidad',
        'dependencia',
        'descripcion',
        'tipo',
        'grupo',
        'estado'
    ];


    /**
     *  Relaciones
     *
     */
    public function aulas()
    {
        return $this->belongsToMany('App\Aula');
    }

    public function reservas()
    {
        return $this->belongsToMany('App\Reserva', 'reservas_activos');
    }

    public function equipos()
    {
        return $this->belongsToMany('App\Equipo', 'equipos_activos');
    }

    /**
     * Scopes
     */

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', '=', $estado);
    }

    public function scopeDependencia($query, $dependencia)
    {
        return $query->where('dependencia', '=', $dependencia);
    }


    public function scopeNotNull($query, $campo)
    {
        return $query->where($campo, '!=', null);
    }

    public function scopeTipos()
    {
        return self::select(['tipo'])
            ->distinct();
    }

    public function scopeMarcas()
    {
        return self::select(['marca'])
            ->distinct();
    }
}
