<?php

namespace App\Http\Requests\Pickup;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_date' => ['required', 'date', 'after_or_equal:today'],
            'timeslot' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
        ];
    }
}
