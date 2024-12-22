<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'     => ['required','string', 'min:3', 'max:50'],
            'password' => ['required','string' ,'min:8', 'max:16'],
            'email'    => ['required','string','email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'active'   => ['nullable','boolean'],
        ];

        if( $this->method() == 'PUT' ) {
            $rules['password'] = ['nullable','string', 'min:8', 'max:16'];
        }

        return $rules;
    }
    
}
