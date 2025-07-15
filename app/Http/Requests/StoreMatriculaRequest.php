<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Importa la clase Rule
use App\Models\Estudiante; // Importa el modelo Estudiante

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
            'cedula_estudiante' => 'required|string|max:20|exists:estudiantes,cedula', // 'exists' valida que la cédula exista en la tabla estudiantes

            'fecha_inscripcion' => 'required|date|date_format:Y-m-d',
            'periodo_academico' => 'required|string',
            'trayecto_id' => 'required|exists:trayectos,id', // Ajusta 'nullable'/'required'
            'condicion_inscripcion' => 'required|string',
            'condicion_cohorte' => 'required|string',
            // ... otras reglas para tus campos
        ];
    }

    /**
     * Prepare the data for validation.
     * Este método se ejecuta ANTES de que se apliquen las reglas de validación.
     * Es ideal para manipular los datos de entrada antes de la validación.
     */
    protected function prepareForValidation(): void
    {
        // Busca al estudiante por su cédula
        // Asegúrate de que $this->cedula_estudiante existe antes de intentar buscar
        if ($this->has('cedula_estudiante') && $this->cedula_estudiante !== null) {
            $estudiante = Estudiante::where('cedula', $this->cedula_estudiante)->first();

            // Si el estudiante es encontrado, añade su ID al request data.
            // Esto hará que 'estudiante_id' esté disponible en $validatedData en el controlador.
            if ($estudiante) {
                $this->merge([
                    'estudiante_id' => $estudiante->id,
                ]);
            }
            // No es necesario un 'else' aquí para manejar el caso de no encontrado directamente,
            // ya que la regla 'exists:estudiantes,cedula' en 'rules()' ya se encargará de ello.
        }
    }


    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'cedula_estudiante.exists' => 'La cédula del estudiante no existe en nuestros registros.', // <-- Mensaje añadido aquí
            'estudiante_id.unique' => 'Este estudiante ya está inscrito en esta combinación de programa, sección, período y trayecto.',
            'estudiante_id.required' => 'El campo estudiante es obligatorio.',
            'programa_id.required' => 'El campo programa es obligatorio.',
            // ... más mensajes personalizados para otros campos
        ];
    }
}
