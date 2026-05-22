<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

}
