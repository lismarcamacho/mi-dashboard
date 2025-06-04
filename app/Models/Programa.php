<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //

        protected $fillable = [
        'codigo_programa',
        'nombre_programa',
        'fecha',
        'descripcion',
    ];

     protected $guarded = ['id'];


}
