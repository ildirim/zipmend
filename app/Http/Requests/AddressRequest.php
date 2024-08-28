<?php

namespace App\Http\Requests;

class AddressRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'addresses' => ['required', 'array', 'min:1'],
            'addresses.*.country' => ['required', 'string', 'size:2'],
            'addresses.*.zip' => ['required', 'string', 'regex:/^\d{5}$/'],
            'addresses.*.city' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'addresses.required' => 'The addresses field is required.',
            'addresses.array' => 'The addresses field must be an array.',
            'addresses.min' => 'At least one address must be provided.',
            'addresses.*.country.required' => 'The country field is required.',
            'addresses.*.country.size' => 'The country field must be exactly 2 characters.',
            'addresses.*.zip.required' => 'The ZIP code is required.',
            'addresses.*.zip.regex' => 'The ZIP code must be a 5-digit number.',
            'addresses.*.city.required' => 'The city field is required.',
        ];
    }
}
