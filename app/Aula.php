<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{


    use DatesTranslator;

    protected $table = 'espacios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'sede',
        'descripcion',
        'dependencia',
        'capacidad',
        'tipo',
        'estado'
    ];

    /**
     *  Relaciones
     *
     */
    public function activos()
    {
        return $this->belongsToMany('App\Activo');
    }

    public function reservas()
    {
        return $this->hasMany('App\Reserva');
    }


    /**
     *
     * Gets
     * @param $query
     * @param $estado
     * @return
     */

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', '=', $estado);
    }


    /**
     * @param $query
     * @param $dependencia
     * @param null $operator
     * @return mixed
     */
    public function scopeDependencia($query, $dependencia, $operator = null)
    {
        return $query->where('dependencia', isset($operator) ? $operator : '=', $dependencia);
    }

    /**
     * @param $query
     * @param $sede
     * @return mixed
     */
    public function scopeSede($query, $sede)
    {
        return $query->where('sede', '=', $sede);
    }

}
