<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estudiantes'; // Especifica el nombre de la tabla si no sigue la convención de pluralización (ej. si fuera 'alumno' y la tabla 'alumnos')

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // Especifica la clave primaria si no se llama 'id'

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Indica que la tabla tiene las columnas created_at y updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cedula',
        'apellidos_nombres',
        'fecha_nacimiento',
        'email',
        'telefono',
        'sede',
        'municipio',
        'parroquia',
        'estatus_activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date', // Laravel convierte automáticamente la fecha a un objeto Carbon
        'estatus_activo' => 'boolean', // Laravel convierte 0/1 a true/false
    ];

    /**
     * The attributes that should be hidden for serialization.
     * (Opcional, si hay atributos que no quieres que se muestren fácilmente, ej. contraseñas)
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password', // Por ejemplo, si tuvieras un campo de contraseña aquí
    ];

    // Puedes definir relaciones con otros modelos aquí
    // Por ejemplo, un estudiante tiene muchas matrículas
    // public function matriculas()
    // {
    //     return $this->hasMany(Matricula::class, 'estudiante_id', 'id');
    // }
}
