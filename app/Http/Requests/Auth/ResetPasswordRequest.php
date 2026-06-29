<?php

namespace App\Http\Requests\Auth;

use App\Validation\PasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => PasswordRules::rules(),
        ];
    }

    public function messages(): array
    {
        return PasswordRules::messages();
    }
}
