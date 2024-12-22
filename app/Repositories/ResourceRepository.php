<?php

namespace App\Repositories;

use App\Models\Resource;

class ResourceRepository
{
    protected $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function all()
    {
        return $this->resource->with('permissions')->get();
    }
}
