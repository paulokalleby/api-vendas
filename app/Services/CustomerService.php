<?php

namespace App\Services;

use App\Repositories\CustomerRepository;

class CustomerService
{
    protected $customer;

    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    public function getAllCustomers(array $filters)
    {
        return $this->customer->all($filters);
    }

    public function findCustomerById(string $id)
    {
        return $this->customer->find($id);
    }

    public function createCustomer(array $data)
    {
        return $this->customer->create($data);
    }

    public function updateCustomer(array $data, string $id)
    {
        return $this->customer->update($data, $id);
    }

    public function deleteCustomer(string $id)
    {
        return $this->customer->delete($id);
    }
}
