<?php

namespace App\Validation;

class PasswordRules
{
    /**
     * Règles d'un mot de passe fort, centralisées (inscription, réinitialisation,
     * changement de mot de passe).
     *
     * @return array<int, string>
     */
    public static function rules(bool $confirmed = false): array
    {
        $rules = [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[-@$!%*#?&]/',
        ];

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }

    /**
     * Messages d'erreur associés.
     *
     * @return array<string, string>
     */
    public static function messages(string $field = 'password'): array
    {
        return [
            "{$field}.required" => 'Le mot de passe est requis',
            "{$field}.min" => 'Le mot de passe doit contenir au minimum 8 caractères',
            "{$field}.confirmed" => 'Les mots de passe ne correspondent pas',
            "{$field}.regex" => 'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial',
        ];
    }
}
