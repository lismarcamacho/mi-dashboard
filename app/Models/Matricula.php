<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas'; // Asegúrate que el nombre de tu tabla sea 'matriculas'

    protected $fillable = [
        'estudiante_id', // Asegúrate que esta columna exista en tu tabla 'matriculas'
        'programa_id',
        'seccion_id',
        'fecha_inscripcion',
        'periodo_academico',
        'trayecto_id',
        'condicion_inscripcion',
        'condicion_cohorte',
        'malla_id',
    ];

    /**
     * Get the estudiante that owns the Matricula.
     * Esta relación asume que hay una columna 'estudiante_id' en la tabla 'matriculas'
     * que apunta a la clave primaria 'id' de la tabla 'estudiantes'.
     * Si la clave foránea en 'matriculas' se llamara diferente (ej. 'id_estudiante'),
     * entonces deberías especificarlo: return $this->belongsTo(Estudiante::class, 'id_estudiante');
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /**
     * Get the seccion that owns the Matricula.
     * Asume 'seccion_id' como clave foránea.
     */
    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    /**
     * Get the programa that owns the Matricula.
     * Asume 'programa_id' como clave foránea.
     */
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programa_id');
    }

    /**
     * Get the trayecto that owns the Matricula.
     * Asume 'trayecto_id' como clave foránea.
     */
    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class, 'trayecto_id');
    }

    // ... otras relaciones
}