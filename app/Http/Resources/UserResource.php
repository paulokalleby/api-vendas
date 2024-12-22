<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $token = $this->tokens()->latest()->first();

        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'tenant'  => $this->tenant->name,
            'email'   => $this->email,
            'owner'   => $this->owner,
            'active'  => $this->active,
            'created' => $this->created_at,
            'updated' => $this->updated_at,
            'roles'   => RoleResource::collection($this->whenLoaded('roles')),
            'session' => $this->tokens->last()?->name ?? '',
        ];
    }
}
