<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'whatsapp' => $this->whatsapp,
            'address'  => $this->address,
            'active'   => $this->active,
            'created'  => $this->created_at,
            'updated'  => $this->updated_at,
        ];
    }
}
