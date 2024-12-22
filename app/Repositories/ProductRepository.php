<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all(array $filters = [])
    {
        $query =  $this->product
            ->with('category')
            ->when($filters, function (Builder $query) use ($filters) {

                if (isset($filters['name']))
                    $query->where('name', 'LIKE', "%{$filters['name']}%");

                if (isset($filters['category_id']))
                    $query->whereCategoryId($filters['category_id']);

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
        return $this->product->with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {

            $image = $data['image'];
            $data['image'] = $image->store(Auth::user()->tenant_id, 'public');
        }

        return $this->product->create($data);
    }

    public function update(array $data, string $id)
    {
        $product = $this->product->findOrFail($id);

        if (isset($data['image'])) {

            $image = $data['image'];

            $data['image'] = $image->store(Auth::user()->tenant_id, 'public');

            if (isset($product->image) && Storage::disk('public')->exists($product->image)) {

                Storage::disk('public')->delete($product->image);
            }
        }

        $product->update($data);

        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $product = $this->product->findOrFail($id);

        if (isset($product->image) && Storage::disk('public')->exists($product->image)) {

            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
