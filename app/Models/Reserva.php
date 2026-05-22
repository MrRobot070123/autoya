<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'vehiculo_id',
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'precio_total',
        'estado',
        'numero_contrato'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    
    public function getColorEstadoAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'bg-warning',
            'confirmada' => 'bg-primary',
            'pagada' => 'bg-success',
            'cancelada' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
