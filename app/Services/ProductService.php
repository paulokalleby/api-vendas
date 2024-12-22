<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function getAllProducts(array $filters)
    {
        return $this->product->all($filters);
    }

    public function findProductById(string $id)
    {
        return $this->product->find($id);
    }

    public function createProduct(array $data)
    {
        return $this->product->create($data);
    }

    public function updateProduct(array $data, string $id)
    {
        return $this->product->update($data, $id);
    }

    public function deleteProduct(string $id)
    {
        return $this->product->delete($id);
    }
}
