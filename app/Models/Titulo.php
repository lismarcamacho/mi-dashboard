<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Titulo extends Model
{
    use HasFactory;

    protected $table = 'titulos';

    protected $fillable = [
     'nombre',
     'duracion',
     'especialidad_id',
    ];
     
     protected $guarded = ['id'];

 
     // Get the career that owns the title.
    
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id', 'id');
    }
}
