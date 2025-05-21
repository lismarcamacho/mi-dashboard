<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UnidadCurricular extends Model
{
    // Si el nombre de tu tabla no es 'products', especifícalo aquí:
    protected $table = 'UnidadCurricular';

    // Si tu clave primaria no es 'id', especifícala aquí:
    protected $primaryKey = 'id_UnidadCurricular';

    // Si tu clave primaria es autoincremental:
    public $incrementing = true;

    // Si el tipo de dato de tu clave primaria no es un entero:
    protected $keyType = 'int';
    // Para habilitar la asignación masiva (llenar atributos con un array):
    // protected $fillable = ['nombre_del_campo1', 'nombre_del_campo2', ...];

    // Para evitar la asignación masiva de ciertos campos:
    protected $guarded = ['id_UnidadCurricular']; // Por ejemplo, para proteger la clave primaria
}




