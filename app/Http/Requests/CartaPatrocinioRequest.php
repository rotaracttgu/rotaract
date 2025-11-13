<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartaPatrocinioRequest extends FormRequest
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
        $cartaId = $this->route('id');
        
        return [
            'numero_carta' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('carta_patrocinios', 'numero_carta')->ignore($cartaId),
            ],
            'destinatario' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!$this->validarCaracteresRepetidos($value)) {
                        $fail('El destinatario no puede contener más de 2 caracteres repetidos consecutivos.');
                    }
                },
            ],
            'descripcion' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value && !$this->validarCaracteresRepetidos($value)) {
                        $fail('La descripción no puede contener más de 2 caracteres repetidos consecutivos.');
                    }
                },
            ],
            'monto_solicitado' => 'required|numeric|min:0',
            'estado' => 'nullable|in:Pendiente,Aprobada,Rechazada,En Revision',
            'fecha_solicitud' => 'nullable|date',
            'fecha_respuesta' => 'nullable|date',
            'proyecto_id' => 'required|exists:proyectos,ProyectoID',
            'observaciones' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value && !$this->validarCaracteresRepetidos($value)) {
                        $fail('Las observaciones no pueden contener más de 2 caracteres repetidos consecutivos.');
                    }
                },
            ],
        ];
    }

    /**
     * Validar que no haya más de 2 caracteres repetidos consecutivos
     */
    private function validarCaracteresRepetidos(string $texto): bool
    {
        // Patron para detectar 3 o más caracteres iguales consecutivos
        return !preg_match('/(.)\1{2,}/', $texto);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'destinatario.required' => 'El destinatario es obligatorio.',
            'destinatario.max' => 'El destinatario no puede exceder 255 caracteres.',
            'descripcion.string' => 'La descripción debe ser texto válido.',
            'monto_solicitado.required' => 'El monto solicitado es obligatorio.',
            'monto_solicitado.numeric' => 'El monto solicitado debe ser un número.',
            'monto_solicitado.min' => 'El monto solicitado no puede ser negativo.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'fecha_solicitud.date' => 'La fecha de solicitud debe ser una fecha válida.',
            'fecha_respuesta.date' => 'La fecha de respuesta debe ser una fecha válida.',
            'proyecto_id.required' => 'El proyecto es obligatorio.',
            'proyecto_id.exists' => 'El proyecto seleccionado no existe.',
        ];
    }
}
