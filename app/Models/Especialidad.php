<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- ADD THIS LINE!

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

        protected $fillable = [
        'codigo_especialidad',
        'nombre_especialidad',
        'titulo',
        'duracion_x_titulo',
        'descripcion',
    ];

    

     protected $guarded = ['id'];

     public function programa()
{
    return $this->belongsTo(Programa::class, 'programa_id');
}

}
