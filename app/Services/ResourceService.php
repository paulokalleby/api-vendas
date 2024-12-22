<?php

namespace App\Services;

use App\Repositories\ResourceRepository;

class ResourceService
{
    protected $resource;

    public function __construct(ResourceRepository $resource)
    {
        $this->resource = $resource;
    }

    public function getAllResources()
    {
        return $this->resource->all();
    }
}
