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
    // Un Trayecto tiene muchas Unidades Curriculares
    public function unidadesCurriculares()
    {
        // 'UnidadCurricular::class' se refiere al modelo relacionado.
        // 'trayecto_id' es la clave foránea en la tabla 'unidades_curriculares'
        // que apunta al 'id' de la tabla 'trayectos'.
        return $this->hasMany(UnidadCurricular::class, 'trayecto_id');
    }
    public function mallasCurriculares()
    {
        return $this->belongsToMany(MallaCurricular::class, 'malla_trayecto', 'trayecto_id', 'malla_curricular_id');
    }
}
