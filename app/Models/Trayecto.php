<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Especialidad;

class Trayecto extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nombre_trayecto',
        'descripcion',
      
        'especialidad_id', // Asegúrate de que esté aquí para Asignación Masiva
    ];
    
    protected $guarded = ['id'];
    /**
     * Get the especialidad that owns the Trayecto.
     */
    public function especialidad()
    {
        // Un Trayecto pertenece a UNA Especialidad
        return $this->belongsTo(Especialidad::class, 'especialidad_id', 'id');
    }
}
