<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //

        protected $fillable = [
        'nombre_programa',
        'descripcion',
    ];

     protected $guarded = ['id'];


}
