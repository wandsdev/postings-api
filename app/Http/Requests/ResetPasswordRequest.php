<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ResetPasswordRequest extends FormRequest
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
            'validation_code' => 'required|string|min:8|max:8',
            'password' => 'required|string|confirmed|min:8|max:50',
            'password_confirmation' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email é obrigatório.',
            'email.string' => 'Email deve ser string.',
            'email.max' => 'Email deve ter no máximo 50 caracteres.',
            'email.email' => 'Email não é válido.',

            'validation_code.required' => 'Código de verificação é obrigatório.',
            'validation_code.string' => 'Código de verificação deve ser string.',
            'validation_code.min' => 'Código de verificação inválido.',
            'validation_code.max' => 'Código de verificação inválido.',

            'password.required' => 'Senha é obrigatório.',
            'password.string' => 'Senha deve ser string.',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres.',
            'password.max' => 'Senha deve ter no máximo 50 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',

            'password_confirmation.required' => 'Campo Repetir Senha é obrigatório.',
        ];
    }
}
