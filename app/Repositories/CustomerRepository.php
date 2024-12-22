<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

class CustomerRepository
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function all(array $filters = [])
    {
        $query =  $this->customer
            ->with('tokens')
            ->when($filters, function (Builder $query) use ($filters) {

                if (isset($filters['name']))
                    $query->where('name', 'LIKE', "%{$filters['name']}%");

                if (isset($filters['email']))
                    $query->where('email', 'LIKE', "%{$filters['email']}%");

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
        return $this->customer->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->customer->create($data);
    }

    public function update(array $data, string $id)
    {
        $customer = $this->customer->findOrFail($id);

        $customer->update($data);

        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $customer = $this->customer->findOrFail($id);

        $customer->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
