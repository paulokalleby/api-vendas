<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'identify' => $this->identify,
            'status'   => $this->status,
            'total'    => total($this->products),
            'created'  => $this->created_at,
            'updated'  => $this->updated_at,
            'payment'  => new PaymentResource($this->payment),
            'user'     => new UserResource($this->user),
            'customer' => new CustomerResource($this->customer),
            'products' => OrderProductResource::collection(
                $this->whenLoaded('products')
            ),
        ];
    }
}
