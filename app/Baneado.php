<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baneado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responsable',
        'motivo',
        'actual',
    ];

    /**
     *  Relaciones
     *
     */
    public function usuario()
    {
        return $this->belongsTo('App\User', 'usuario_id');
    }

}
