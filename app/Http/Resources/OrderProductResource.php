<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'     => $this->name,
            'quantity' => $this->pivot->quantity,
            'price'    => $this->pivot->price,
        ];
    }
}
