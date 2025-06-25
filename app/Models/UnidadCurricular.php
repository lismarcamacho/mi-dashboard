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
        'anio_de_vigencia_de_entrada',
        'anio_de_salida_vigencia',

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
     * Relación de muchos a muchos: Una UnidadCurricular puede estar en muchas Mallas Curriculares.
     * La tabla pivote 'malla_unidad_curricular' une ambos modelos y contiene datos adicionales.
     * @return \Illuminate->Database->Eloquent->Relations->BelongsToMany
     */
    public function mallasCurriculares()
    {
        return $this->belongsToMany(
            MallaCurricular::class,
            'malla_unidad_curricular', // Nombre de la tabla pivote
            'unidad_curricular_id',    // FK de este modelo (UnidadCurricular) en la tabla pivote
            'malla_curricular_id'      // FK del modelo relacionado (MallaCurricular) en la tabla pivote
        )->withPivot('trayecto_id', 'minimo_aprobatorio', 'tipo_uc_en_malla', 'periodo_de_carga', 'numero_de_fase'); // ¡Añadidos nuevos campos al pivote!
    }

    

    public function trayecto()
    {
        return $this->belongsTo(Trayecto::class, 'trayecto_id');
    }
}
