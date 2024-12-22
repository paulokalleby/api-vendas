<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function getAllUsers(array $filters)
    {
        return $this->user->all($filters);
    }

    public function findUserById(string $id)
    {
        return $this->user->find($id);
    }

    public function createUser(array $data)
    {
        return $this->user->create($data);
    }

    public function updateUser(array $data, string $id)
    {
        return $this->user->update($data, $id);
    }

    public function deleteUser(string $id)
    {
        return $this->user->delete($id);
    }
}
