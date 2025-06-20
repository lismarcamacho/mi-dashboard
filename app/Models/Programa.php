<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //

        protected $fillable = [
        'codigo_programa',
        'nombre_programa',
        'fecha_programa',
        'descripcion',
    ];

     protected $guarded = ['id'];

         protected $casts = [
        'fecha_programa' => 'date', // Esto asegura que sea un objeto Carbon
    ];
 /**
     * Un programa puede tener muchas especialidades.
     */
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'programa_especialidad', 'programa_id', 'especialidad_id');
    }



}
