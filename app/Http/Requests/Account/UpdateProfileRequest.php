<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'language' => ['required', 'string', 'max:50'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
        ];
    }

    public function messages(): array
    {
        return [
            'lastname.min' => 'Le nom doit faire plus de 2 caractères',
            'firstname.min' => 'Le prénom doit faire plus de 2 caractères',
            'phone.regex' => 'Le numéro de téléphone doit être valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'avatar.image' => 'Le fichier doit être une image',
            'avatar.mimes' => 'Formats acceptés : jpeg, png, jpg, gif, webp',
            'avatar.max' => 'L\'image ne peut pas dépasser 8 Mo',
        ];
    }
}
