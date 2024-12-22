<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id', 'uuid'],
            'name'        => ['required', 'string', 'min:2', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
            'price'       => ['required'],
            'image'       => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'active'      => ['nullable', 'boolean']
        ];
    }
}
