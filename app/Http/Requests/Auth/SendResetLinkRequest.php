<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendResetLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez entrer une adresse email',
            'email.email' => 'Adresse email invalide',
            'email.exists' => 'Aucun compte trouvé avec cet email',
        ];
    }
}
