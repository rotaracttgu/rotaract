<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartaFormalRequest extends FormRequest
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
                Rule::unique('carta_formals', 'numero_carta')->ignore($cartaId),
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
            'asunto' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!$this->validarCaracteresRepetidos($value)) {
                        $fail('El asunto no puede contener más de 2 caracteres repetidos consecutivos.');
                    }
                },
            ],
            'contenido' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!$this->validarCaracteresRepetidos($value)) {
                        $fail('El contenido no puede contener más de 2 caracteres repetidos consecutivos.');
                    }
                },
            ],
            'tipo' => 'required|in:Invitacion,Agradecimiento,Solicitud,Notificacion,Otro',
            'estado' => 'nullable|in:Borrador,Enviada,Recibida',
            'fecha_envio' => 'nullable|date',
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
            'asunto.required' => 'El asunto es obligatorio.',
            'asunto.max' => 'El asunto no puede exceder 255 caracteres.',
            'contenido.required' => 'El contenido es obligatorio.',
            'tipo.required' => 'El tipo de carta es obligatorio.',
            'tipo.in' => 'El tipo de carta seleccionado no es válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'fecha_envio.date' => 'La fecha de envío debe ser una fecha válida.',
        ];
    }
}
