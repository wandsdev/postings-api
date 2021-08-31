<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email é obrigatório.',
            'email.string' => 'Email deve ser string.',
            'email.max' => 'Email deve ter no máximo 50 caracteres.',
            'email.email' => 'Email não é válido.',

            'password.required' => 'Senha é obrigatório.',
            'password.string' => 'Senha deve ser string.',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres.',
            'password.max' => 'Senha deve ter no máximo 50 caracteres.',
        ];
    }
}
