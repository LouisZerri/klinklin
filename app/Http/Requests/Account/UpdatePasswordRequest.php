<?php

namespace App\Http\Requests\Account;

use App\Validation\PasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => PasswordRules::rules(confirmed: true),
        ];
    }

    public function messages(): array
    {
        return array_merge([
            'current_password.required' => 'Le mot de passe actuel est requis',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect',
        ], PasswordRules::messages());
    }
}
