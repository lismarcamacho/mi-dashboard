<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    //use HasFactory;

        protected $fillable = [
        'codigo_carrera',
        'nombre_carrera',
        'titulo',
        'duracion_x_titulo',
        'descripcion',
    ];

     protected $guarded = ['id'];

}
