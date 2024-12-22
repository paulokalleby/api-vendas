<?php

namespace App\Http\Requests;

use App\Enums\OrdersStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'payment_id'            => ['required', 'exists:payments,id', 'uuid'],
            'customer_id'           => ['required', 'exists:cutomers,id', 'uuid'],
            'products'              => ['required', 'array'],
            'products.*.product_id' => ['required', 'exists:products,id', 'uuid'],
            'products.*.quantity'   => ['required', 'integer', 'min:1'],
        ];

        if ($this->method() == 'PUT') {
            $rules = [];
            $rules['status'] = ['required', Rule::in(array_keys(OrdersStatusEnum::cases()))];
        }

        return $rules;
    }
}
