<?php

namespace App;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Reserva extends Model
{

    use DatesTranslator;
    /**
     * @var array
     */

    protected $dates = ['fecha_reserva'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo_reserva',
        'fecha_reserva',
        'fecha_final_reserva',
        'hora_inicio',
        'hora_final',
        'dependencia',
        'observaciones',
        'tipo',
        'descripcion_aula',
        'estado'
    ];

    /**
     *  Relaciones
     *
     */
    public function usuario()
    {
        return $this->belongsTo('App\User', 'usuario_id');
    }

    public function administrador()
    {
        return $this->belongsTo('App\User', 'administrador_id');
    }

    public function aula()
    {
        return $this->belongsTo('App\Aula', 'espacio_id');
    }

    public function activos()
    {
        return $this->belongsToMany('App\Activo', 'reservas_activos');
    }



    /***
     * Scopes
     */

    //Buscar por usuario

    public function scopeByUsuario($query, $usuario)
    {
        return $query->where('usuario_id', '=', $usuario);
    }

    //Buscar por codigo
    public function scopeCodigo($query, $codigo)
    {
        return $query->where('codigo_reserva', '=', $codigo);
    }

    //Buscar por tipo
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', '=', $tipo);
    }

    //Buscar por Estado
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', '=', $estado);
    }

    /**
     * Get
     */

    public function getFechaReservaAttribute($fechaReserva)
    {
        return new Date($fechaReserva);
    }

    /**
     *  Set
     */

    public function setFechaReservaAttribute($value)
    {
        return $this->attributes['fecha_reserva'] = date('Y-m-d', strtotime(str_replace("/", "-", $value)));
    }


    public function setHoraInicioAttribute($value)
    {
        return $this->attributes['hora_inicio'] = Carbon::createFromFormat('h:i a', $value);
    }

    public function setHoraFinalAttribute($value)
    {
        return $this->attributes['hora_final'] = Carbon::createFromFormat('h:i a', $value);
    }

}
