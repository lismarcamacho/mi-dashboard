<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MallaCurricular extends Model
{
    use HasFactory;

    protected $table = 'mallas_curriculares';

    protected $fillable = [
        'nombre',
        'id_especialidad',
        'id_programa', // Nuevo campo 24-06-25 para vincular directamente al programa
        'minimo_aprobatorio',
        'duracion_en_malla',
        'fase_malla',
        'tipo_uc_en_malla',
        'anio_de_vigencia_de_entrada_malla',
        'creditos_en_malla',
        'anio_salida_vigencia',
    ];

    protected $casts = [
        'minimo_aprobatorio' => 'float',
        'anio_de_vigencia_de_entrada_malla' => 'integer',
        'creditos_en_malla' => 'integer',
        'id_programa' => 'integer', // Castear el nuevo campo
    ];

    /**
     * Define la relación de muchos a uno con Especialidad.
     * Una entrada de malla pertenece a una especialidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad', 'id');
    }

    /**
     * Define la relación de muchos a uno con Programa.
     * Una entrada de malla pertenece a un programa.
     * Es importante asegurar la consistencia si también se usa 'id_especialidad'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programa() // nuevo 24-06-25
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id');
    }

    /**
     * Relación de muchos a muchos: Una MallaCurricular tiene muchas Unidades Curriculares.
     * La tabla pivote 'malla_unidad_curricular' une ambos modelos y contiene datos adicionales.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unidadesCurriculares()
    {
        return $this->belongsToMany(
            UnidadCurricular::class,
            'malla_unidad_curricular', // Nombre de la tabla pivote
            'malla_curricular_id',    // FK de este modelo (MallaCurricular) en la tabla pivote
            'unidad_curricular_id'    // FK del modelo relacionado (UnidadCurricular) en la tabla pivote
        )->withPivot('trayecto_id', 'minimo_aprobatorio', 'tipo_uc_en_malla', 'periodo_de_carga', 'numero_de_fase'); // ¡Añadidos nuevos campos al pivote!
    }

    /**
     * Relación de muchos a muchos con Trayecto (usando la tabla pivote malla_curricular_trayecto)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trayectos()
    {
        return $this->belongsToMany(Trayecto::class, 'malla_curricular_trayecto', 'malla_curricular_id', 'trayecto_id');
    }

    /**
     * Define la relación de uno a muchos con Prelacion (como malla afectada).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prelacionesComoAfectada()
    {
        return $this->hasMany(Prelacion::class, 'id_malla_afectada', 'id');
    }

    /**
     * Define la relación de uno a muchos con Prelacion (como requisito).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prelacionesComoRequisito()
    {
        return $this->hasMany(Prelacion::class, 'id_malla_requisito', 'id');
    }

    /**
     * Accesor para una descripción completa de la Malla Curricular.
     *
     * @return string
     */
    public function getDescripcionCompletaAttribute()
    {
        $especialidadNombre = $this->especialidad ? $this->especialidad->nombre : 'Desconocida';
        $programaNombre = $this->programa ? $this->programa->nombre : 'Desconocido';
        return "Malla: {$this->nombre}, Especialidad: {$especialidadNombre}, Programa: {$programaNombre}, Fase: {$this->fase_malla}";
    }
}
