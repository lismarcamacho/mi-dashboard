<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;
     // ¡MUY IMPORTANTE! Especifica el nombre de la tabla
    protected $table = 'secciones';
    protected $fillable = ['nombre', 'capacidad_maxima'];
    public function matriculas() { return $this->hasMany(Matricula::class); } // Relación inversa
}