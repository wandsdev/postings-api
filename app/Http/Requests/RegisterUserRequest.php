<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email|max:50|unique:users',
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
            'name.required' => 'Nome é obrigatório.',
            'name.string' => 'Nome deve ser string.',
            'name.min' => 'Nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'Nome deve ter no máximo 50 caracteres.',

            'email.required' => 'Email é obrigatório.',
            'email.string' => 'Email deve ser string.',
            'email.max' => 'Email deve ter no máximo 50 caracteres.',
            'email.email' => 'Email não é válido.',
            'email.unique' => 'Email já cadastrado.',

            'password.required' => 'Senha é obrigatório.',
            'password.string' => 'Senha deve ser string.',
            'password.min' => 'Senha deve ter no mínimo 8 caracteres.',
            'password.max' => 'Senha deve ter no máximo 50 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',

            'password_confirmation.required' => 'Campo Repetir Senha é obrigatório.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['message' => 'Dados fornecidos inválidos', 'errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
