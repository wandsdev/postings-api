<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendValidateCodeRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email é obrigatório.',
            'email.string' => 'Email deve ser string.',
            'email.max' => 'Email deve ter no máximo 50 caracteres.',
            'email.email' => 'Email não é válido.',
        ];
    }
}
