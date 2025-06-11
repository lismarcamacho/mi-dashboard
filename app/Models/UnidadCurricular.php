<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadCurricular extends Model
{
    use HasFactory;
    protected $table = 'unidades_curriculares';

    // Para habilitar la asignación masiva (llenar atributos con un array):
    protected $fillable = [
    'codigo',
    'nombre',
    'creditos',
    'horas_semanales',
    'horas_trabajo_asistidas',
    'horas_trabajo_independiente',
    'horas_trabajo_estudiantil',
    'eje',
    'descripcion',
    
    ];

    // Para evitar la asignación masiva de ciertos campos:
    // Usar $fillable es generalmente preferible a $guarded,
    // y la clave primaria 'id' está protegida por defecto.
    // protected $guarded = ['id']; // Si usas $fillable, esta línea es redundante para 'id'.

    // Opcional: Definir tipos de datos para los atributos (casts).
    // Esto asegura que Laravel devuelva estos atributos en el formato correcto (ej. enteros, float).
    protected $casts = [
        'creditos' => 'integer', // Asegura que los créditos sean un número decimal
        'horas_semanales' => 'integer',
        'horas_trabajo_asistidas' => 'integer',
        'horas_trabajo_independiente' => 'integer',
        'horas_trabajo_estudiantil' => 'integer',
    ];



    /**
     * Define la relación de uno a muchos con MallaCurricular.
     * Una unidad curricular puede estar en muchas entradas de la malla.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mallasCurriculares()
    {
        return $this->hasMany(MallaCurricular::class, 'id_unidad_curricular', 'id');
        // 'MallaCurricular::class' es el nombre del modelo de la malla (aún no lo hemos creado, pero lo haremos)
        // 'id_unidad_curricular' es la FK en la tabla 'mallas_curriculares'
        // 'id' es la PK local en esta tabla 'unidades_curriculares'
    }

    // Aquí podrías añadir otras relaciones futuras, como si una unidad curricular tiene pre-requisitos
    // (a través de la tabla Prelaciones y MallaCurricular), o profesores, etc.
  


}
