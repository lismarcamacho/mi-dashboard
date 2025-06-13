<?php

namespace App\Models;

use App\Models\Trayecto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MallaCurricular extends Model
{
    use HasFactory;

    // Si tu tabla no sigue la convención de nombres en plural (mallas_curriculares),
    // especifica el nombre exacto de la tabla aquí.
    // protected $table = 'mallas_curriculares'; // Laravel debería inferirlo correctamente

    // Para habilitar la asignación masiva.
    // Incluye todos los campos que pueden ser asignados al crear o actualizar una entrada de malla.

    protected $table = 'mallas_curriculares';

    protected $fillable = [
        'nombre',
        'id_especialidad',
        'id_unidad_curricular',
        'id_trayecto', // Ya que ahora manejamos id_trayecto como FK
        'id_unidad_curricular',
        'minimo_aprobatorio',
        'duracion_en_malla',
        'fase_malla',
        'tipo_uc_en_malla',
        'anio_de_vigencia_de_entrada_malla',
        'creditos_en_malla',
        'anio_salida_vigencia',
    ];

    // Opcional: Definir tipos de datos para los atributos (casts).
    // Asegura que los valores sean tratados como el tipo correcto en PHP.
    protected $casts = [
        'minimo_aprobatorio' => 'float', // Las notas pueden tener decimales
        'anio_de_vigencia_de_entrada_malla' => 'integer',
        'creditos_en_malla' => 'integer', // Confirmamos que los créditos son enteros
    ];

    /**
     * Define la relación de uno a muchos (inversa) con Especialidad.
     * Una entrada de malla pertenece a una especialidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad', 'id');
        // Asume que tu modelo de especialidad se llama 'Especialidad'.
        // 'id_especialidad' es la FK en esta tabla (mallas_curriculares).
        // 'id' es la PK en la tabla 'especialidades'.
    }

    /**
     * Define la relación de uno a muchos (inversa) con UnidadCurricular.
     * Una entrada de malla se refiere a una unidad curricular.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidadCurricular()
    {
        return $this->belongsTo(UnidadCurricular::class, 'id_unidad_curricular', 'id');
        // 'UnidadCurricular::class' es el nombre del modelo de unidad curricular.
        // 'id_unidad_curricular' es la FK en esta tabla.
        // 'id' es la PK en la tabla 'unidades_curriculares'.
    }

    /**
     * Define la relación de uno a muchos (inversa) con Trayecto.
     * Una entrada de malla pertenece a un trayecto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   /* public function trayecto()
    {
        return $this->belongsTo(Trayecto::class, 'id_trayecto', 'id');
        // Asume que tu modelo de trayecto se llama 'Trayecto'.
        // 'id_trayecto' es la FK en esta tabla.
        // 'id' es la PK en la tabla 'trayectos'.
    }*/
    public function trayectos()
    {
        return $this->belongsToMany(Trayecto::class, 'malla_curricular_trayecto', 'malla_curricular_id', 'trayecto_id');
    }

    /**
     * Define la relación de uno a muchos con Prelacion (como malla afectada).
     * Una entrada de malla puede tener varias prelaciones donde es la afectada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prelacionesComoAfectada()
    {
        return $this->hasMany(Prelacion::class, 'id_malla_afectada', 'id');
    }

    /**
     * Define la relación de uno a muchos con Prelacion (como requisito).
     * Una entrada de malla puede ser requisito para varias otras prelaciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prelacionesComoRequisito()
    {
        return $this->hasMany(Prelacion::class, 'id_malla_requisito', 'id');
    }

    // Aquí podrías añadir otros métodos personalizados relacionados con la lógica de la malla.

    // Puedes añadir un accesor para una descripción legible
    public function getDescripcionCompletaAttribute()
    {
        $ucNombre = $this->unidadCurricular ? $this->unidadCurricular->nombre : 'Desconocida';
        $trayectoNombre = $this->trayecto ? $this->trayecto->nombre : 'Desconocido';
        return "UC: {$ucNombre}, Trayecto: {$trayectoNombre}, Fase: {$this->fase_malla}";
    }
}
