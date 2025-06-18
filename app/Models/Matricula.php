<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    protected $fillable = [
        'estudiante_id', 'programa_id', 'seccion_id', 'fecha_inscripcion',
        'periodo_academico', 'trayecto', 'condicion_inscripcion', 'condicion_cohorte'
    ];
    protected $casts = ['fecha_inscripcion' => 'date'];

    public function estudiante() { return $this->belongsTo(Estudiante::class); }
    public function programa() { return $this->belongsTo(Programa::class); }
    public function seccion() { return $this->belongsTo(Seccion::class); } // Nueva relación
}