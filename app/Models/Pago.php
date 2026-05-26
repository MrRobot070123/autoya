<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'reserva_id',
        'numero_pago',
        'monto',
        'estado',
    ];
    
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
