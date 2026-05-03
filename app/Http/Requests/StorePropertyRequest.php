<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('properties', 'name')],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999999.99'],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:255'],
            'storeys' => ['required', 'integer', 'min:1', 'max:255'],
            'garages' => ['required', 'integer', 'min:0', 'max:255'],
            'is_test' => ['nullable', 'boolean'],
        ];
    }
}
