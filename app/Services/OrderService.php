<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function getAllOrders(array $filters)
    {
        return $this->order->all($filters);
    }

    public function findOrderById(string $id)
    {
        return $this->order->find($id);
    }

    public function createOrder(array $data)
    {
        return $this->order->create($data);
    }

    public function updateOrder(array $data, string $id)
    {
        return $this->order->update($data, $id);
    }

    public function deleteOrder(string $id)
    {
        return $this->order->delete($id);
    }
}
