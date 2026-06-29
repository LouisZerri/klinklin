<?php

namespace App\Http\Requests\Auth;

use App\Validation\PasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lastname' => ['required', 'string', 'min:2', 'max:50'],
            'firstname' => ['required', 'string', 'min:2', 'max:50'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'min:7', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => PasswordRules::rules(),
        ];
    }

    public function messages(): array
    {
        return array_merge([
            'lastname.min' => 'Le nom doit faire plus de 2 caractères',
            'lastname.max' => 'Le nom ne peut pas dépasser 50 caractères',
            'lastname.string' => 'Le nom ne doit pas être une valeur numérique',
            'firstname.min' => 'Le prénom doit faire plus de 2 caractères',
            'firstname.max' => 'Le prénom ne peut pas dépasser 50 caractères',
            'firstname.string' => 'Le prénom ne doit pas être une valeur numérique',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'phone.min' => 'Le numéro de téléphone est trop court',
            'phone.regex' => 'Le numéro de téléphone doit être valide',
        ], PasswordRules::messages());
    }
}
