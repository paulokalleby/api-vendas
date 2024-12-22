<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    protected $role;

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    public function getAllRoles(array $filters)
    {
        return $this->role->all($filters);
    }

    public function findRoleById(string $id)
    {
        return $this->role->find($id);
    }

    public function createRole(array $data)
    {
        return $this->role->create($data);
    }

    public function updateRole(array $data, string $id)
    {
        return $this->role->update($data, $id);
    }

    public function deleteRole(string $id)
    {
        return $this->role->delete($id);
    }
}
