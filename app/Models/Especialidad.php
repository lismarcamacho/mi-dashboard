<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Titulo;   // Asegúrate de que esté aquí
use App\Models\Programa; // Asegúrate de que esté aquí
use App\Models\Trayecto;
use App\Models\MallaCurricular;

class Especialidad extends Model
{
    use HasFactory;
    protected $table = 'especialidades';
    protected $fillable = [
        'codigo_especialidad',
        'nombre_especialidad',
        // MUY IMPORTANTE: Asegúrate de que este nombre coincida EXACTAMENTE con tu base de datos.
        // Si en phpMyAdmin es 'duracion' (como en image_28d7c5.jpg), usa 'duracion'.
        'duracion',
        'descripcion',
        'total_creditos_requeridos',
    ];
    protected $casts = [
        'total_creditos_requeridos' => 'integer', // O 'float' si fuera el caso
    ];
    // La relación con Programa (si existe en tu BD y la usas)
    // Si una Especialidad TIENE UN programa, sería belongsTo
    // Si una Especialidad PUEDE TENER MUCHOS programas, sería hasMany (y el método sería 'programas()')
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programa_id'); // Asegúrate que 'programa_id' exista en la tabla 'especialidades'
    }

    // La relación con Titulos (Una Especialidad tiene muchos Titulos)
    public function titulos()
    {
        return $this->hasMany(Titulo::class, 'especialidad_id', 'id'); // Por defecto busca 'especialidad_id' en la tabla 'titulos'
    }

    public function mallasCurriculares()
    {
        return $this->hasMany(MallaCurricular::class, 'id_especialidad', 'id');
    }
}
