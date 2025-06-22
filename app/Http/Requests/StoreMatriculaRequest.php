<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Importa la clase Rule

class StoreMatriculaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'estudiante_id' => [
                'required',
                'exists:estudiantes,id',
                // Regla de unicidad para la combinación de campos
                Rule::unique('matriculas')->where(function ($query) {
                    return $query->where('programa_id', $this->programa_id) // Usa $this->campo para acceder a los datos del request en FormRequest
                        ->where('seccion_id', $this->seccion_id)
                        ->where('periodo_academico', $this->periodo_academico)
                        ->where('trayecto_id', $this->trayecto_id); // Incluye trayecto_id si es parte de la unicidad
                }),
            ],
            'programa_id' => 'required|exists:programas,id',
            'seccion_id' => 'required|exists:secciones,id',
            'fecha_inscripcion' => 'required|date|date_format:Y-m-d',
            'periodo_academico' => 'required|string',
            'trayecto_id' => 'required|exists:trayectos,id', // Ajusta 'nullable'/'required'
            'condicion_inscripcion' => 'required|string',
            'condicion_cohorte' => 'required|string',
            // ... otras reglas para tus campos
        ];
    }


    // Paso 3: Colocar el método messages() aquí
    public function messages()
    {
        return [
            'estudiante_id.unique' => 'Este estudiante ya está inscrito en esta combinación de programa, sección, período y trayecto.',
            'estudiante_id.required' => 'El campo estudiante es obligatorio.',
            'programa_id.required' => 'El campo programa es obligatorio.',
            // ... más mensajes personalizados para otros campos
        ];
    }
}
