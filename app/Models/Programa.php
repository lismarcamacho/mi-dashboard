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



    // Un Programa tiene muchos Trayectos
    // La clave foránea 'programa_id' estará en la tabla 'trayectos'
    public function trayectos()
    {
        return $this->hasMany(Trayecto::class);
    }

        // Un Programa tiene muchas Mallas Curriculares
    // La clave foránea 'programa_id' estará en la tabla 'mallas_curriculares'
    public function mallasCurriculares()
    {
        return $this->hasMany(MallaCurricular::class);
    }

        // Un Programa puede tener muchas Matriculas (aunque Matricula pertenece a Programa,
    // desde la perspectiva de Programa, un programa tiene muchas matriculas asociadas)
    // La clave foránea 'programa_id' estará en la tabla 'matriculas'
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }




}
