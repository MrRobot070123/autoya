<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiculoImagen extends Model
{
    
    protected $table = 'vehiculo_imagenes';

    protected $fillable = [
        'vehiculo_id',
        'ruta'
    ];

}
