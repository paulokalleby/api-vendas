<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all(array $filters = [])
    {
        $query =  $this->role
            ->when($filters, function (Builder $query) use ($filters) {

                if (isset($filters['name']))
                    $query->where('name', 'LIKE', "%{$filters['name']}%");

                if (isset($filters['active'])) {
                    if ($filters['active'])  $query->whereActive(true);
                    else  $query->whereActive(false);
                };
            });

        if (
            isset($filters['paginate']) &&
            is_numeric($filters['paginate'])
        )
            return $query->paginate($filters['paginate']);
        else
            return $query->get();
    }

    public function find(string $id)
    {
        return $this->role->with('permissions')->findOrFail($id);
    }

    public function create(array $data)
    {
        $role = $this->role->create($data);

        if (isset($data['permissions'])) {

            $role->permissions()->attach(
                array_values($data['permissions'])
            );
        }

        return $role->load('permissions');
    }

    public function update(array $data, string $id)
    {
        $role = $this->role->findOrFail($id);

        $role->update($data);

        if (isset($data['permissions'])) {

            $role->permissions()->sync(
                array_values($data['permissions'])
            );
        }

        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $role = $this->role->findOrFail($id);

        $role->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
