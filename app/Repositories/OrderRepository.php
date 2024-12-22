<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function all(array $filters = [])
    {
        $query =  $this->order
            ->when($filters, function (Builder $query) use ($filters) {

                if (isset($filters['identify']))
                    $query->where('identify', 'LIKE', "%{$filters['identify']}%");

                if (isset($filters['user_id']))
                    $query->whereUserId($filters['user_id']);

                if (isset($filters['customer_id']))
                    $query->whereCustomerId($filters['customer_id']);

                if (isset($filters['payment_id']))
                    $query->wherePaymentId($filters['payment_id']);

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
        return $this->order->with('user', 'customer', 'payment', 'products')->findOrFail($id);
    }

    public function create(array $data)
    {

        $products = collect($data['products'])->map(
            fn($item) => array_merge(
                $item,
                Product::select('price')->find($item['product_id'])->toArray()
            )
        );

        $this->order = $this->order->create([
            'user_id'     => Auth::user()->id,
            'customer_id' => $data['customer_id'],
            'payment_id'  => $data['payment_id'],
            'identify'    => $this->getIdentify(),
        ]);

        $this->order->products()->attach(
            $products->mapWithKeys(
                fn($item) => [
                    $item['product_id'] => [
                        'quantity' => $item['quantity'],
                        'price'    => $item['price'],
                    ]
                ]
            )
        );

        return $this->order;
    }

    public function update(array $data, string $id)
    {
        $order = $this->order->findOrFail($id);

        $order->update($data);

        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $order = $this->order->findOrFail($id);

        $order->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }


    private function getIdentify()
    {
        return ($this->order->count() + 1);
    }
}
