<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'image'       => $this->image ? asset(Storage::url($this->image)) : '',
            'active'      => $this->active,
            'created'     => $this->created_at,
            'updated'     => $this->updated_at,
            'category'    => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
