<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'active'      => $this->active,
            'created'     => $this->created_at,
            'updated'     => $this->updated_at,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
