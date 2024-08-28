<?php

namespace App\Http\Requests;

class AddressRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'addresses' => ['required', 'array', 'min:2'],
            'addresses.*.country' => ['required', 'string'],
            'addresses.*.zip' => ['required', 'string'],
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
            'addresses.required' => 'Adres boş ola bilməz',
            'addresses.array' => 'Adres array tipində olmalıdır',
            'addresses.min' => 'Adres minimal olaraq 2 obyekt olmalıdır',
            'addresses.*.country.required' => 'Ölkə boş ola bilməz',
            'addresses.*.country.string' => 'Ölkə string tipində olmalıdır',
            'addresses.*.zip.required' => 'Zip boş ola bilməz',
            'addresses.*.zip.string' => 'Zip string tipində olmalıdır',
            'addresses.*.city.required' => 'Şəhər boş ola bilməz',
            'addresses.*.city.string' => 'Şəhər string tipində olmalıdır',
        ];
    }
}
