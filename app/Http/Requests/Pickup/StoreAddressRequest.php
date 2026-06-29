<?php

namespace App\Http\Requests\Pickup;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => ['string', 'min:5', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'city' => ['string', 'regex:/^[\pL\s\-]+$/u', 'max:100'],
            'zip_code' => ['string', 'regex:/^[A-Za-z0-9\s\-]+$/u', 'max:20'],
            'order_date' => ['date', 'after_or_equal:today'],
            'timeslot' => ['string'],
        ];
    }

    public function messages(): array
    {
        return [
            'address.min' => 'L’adresse doit contenir au moins :min caractères',
            'address.max' => 'L’adresse ne peut pas dépasser :max caractères',
            'complement.max' => 'Le complément d’adresse ne peut pas dépasser :max caractères',
            'city.regex' => 'La ville ne peut contenir que des lettres, des espaces et des tirets',
            'city.max' => 'La ville ne peut pas dépasser :max caractères',
            'zip_code.regex' => 'Le code postal ne peut contenir que des lettres, chiffres, espaces et tirets',
            'order_date.date' => 'La date de commande doit être une date valide',
            'order_date.after_or_equal' => 'La date de commande ne peut pas être antérieure à aujourd’hui',
        ];
    }
}
