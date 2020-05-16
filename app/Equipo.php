<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{

    use DatesTranslator;


    protected $fillable = [
        'nombre',
        'estado'
    ];

    public function activos()
    {
        return $this->belongsToMany('App\Activo', 'equipos_activos');
    }

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', '=', $estado);
    }
}
