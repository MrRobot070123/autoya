<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    
    protected $table = 'vehiculos';
    
    protected $fillable = [
        'placa',
        'marca_id',
        'modelo_id',
        'tipo_id',
        'anio',
        'tarifa_diaria',
        'ubicacion',
        'estado'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function imagenes()
    {
        return $this->hasMany(VehiculoImagen::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

}
