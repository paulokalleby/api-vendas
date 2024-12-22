<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'min:2', 'max:50'],
            'email'    => ['nullable', 'string', 'email', 'max:120'],
            'whatsapp' => ['nullable', 'celular_com_ddd'],
            'address'  => ['nullable', 'string', 'max:255'],
            'active'   => ['nullable', 'boolean']
        ];
    }
}
