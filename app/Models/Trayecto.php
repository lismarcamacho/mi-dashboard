<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use App\Models\Especialidad;

class Trayecto extends Model
{
    //
    use HasFactory;
    protected $table = 'trayectos'; 

    protected $fillable = [
        'numero_orden',
        'nombre_trayecto',
        'descripcion',
      
    ];
    
    protected $guarded = ['id'];
    /**
     * Get the especialidad that owns the Trayecto.
     */

         protected $casts = [
        'numero_orden' => 'integer', // Asegura que se trate como entero
    ];

}
