<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importa la clase Rule

class UpdateMatriculaRequest extends FormRequest
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
         // $this->matricula es la instancia del modelo que Laravel inyecta en el método update del controlador.
        // Necesitamos su ID para que la regla 'unique' ignore el registro actual durante la edición.
        $matriculaId = $this->matricula->id;

        return [
            'estudiante_id' => [
                'required',
                'exists:estudiantes,id',
                // Regla de unicidad para la combinación de campos.
                // IMPORTANTE: Usa Rule::unique y el método ->ignore($matriculaId)
                // para permitir que la matrícula actual pueda tener su propia combinación de valores.
                Rule::unique('matriculas')->where(function ($query) {
                    return $query->where('programa_id', $this->programa_id)
                                 ->where('seccion_id', $this->seccion_id)
                                 ->where('periodo_academico', $this->periodo_academico)
                                 // Incluye trayecto_id si es parte de la combinación de unicidad para la matrícula
                                 ->where('trayecto_id', $this->trayecto_id);
                })->ignore($matriculaId), // <-- Esto es crucial para el UPDATE
            ],
            'programa_id' => 'required|exists:programas,id',
            'seccion_id' => 'required|exists:secciones,id',
            'fecha_inscripcion' => 'required|date|date_format:Y-m-d',
            'periodo_academico' => 'required|string',
            'trayecto_id' => 'required|exists:trayectos,id', // O 'required' si siempre es obligatorio
            'condicion_inscripcion' => 'required|string',
            // 'condicion_cohorte' => 'required|string', // Si moviste 'anio_cohorte' a estudiantes, remueve esto.
            // ... otras reglas para tus campos de la matrícula
        ];
    }

        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'estudiante_id.unique' => 'Este estudiante ya tiene una matrícula registrada para esta combinación de programa, sección, período y trayecto.',
            // ... tus otros mensajes personalizados para la matrícula
        ];
    }
}
