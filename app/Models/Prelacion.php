<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prelacion extends Model
{
    use HasFactory;

    // Si tu tabla no sigue la convención de nombres en plural (prelaciones),
    // especifica el nombre exacto de la tabla aquí.
    // Como la migración creó 'prelaciones', Laravel lo detectará automáticamente.
    // protected $table = 'prelaciones';

    // Para habilitar la asignación masiva.
    // Los campos que son claves foráneas deben ser fillable si los asignarás directamente.
    protected $fillable = [
        'id_malla_afectada',
        'id_malla_requisito',
        'tipo_prelacion',
    ];

    // Define la relación con la MallaCurricular "afectada" (la que necesita el requisito).
    public function mallaAfectada()
    {
        return $this->belongsTo(MallaCurricular::class, 'id_malla_afectada', 'id');
    }

    // Define la relación con la MallaCurricular que es el "requisito".
    public function mallaRequisito()
    {
        return $this->belongsTo(MallaCurricular::class, 'id_malla_requisito', 'id');
    }

    // Aquí podrías añadir otros métodos o relaciones si fueran necesarios.
}
