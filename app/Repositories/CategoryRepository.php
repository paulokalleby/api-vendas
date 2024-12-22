<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all(array $filters = [])
    {
        $query =  $this->category
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
        return $this->category->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function update(array $data, string $id)
    {
        $category = $this->category->findOrFail($id);

        $category->update($data);

        return response()->json([
            'message' => 'success'
        ], 204);
    }

    public function delete(string $id)
    {
        $category = $this->category->findOrFail($id);

        $category->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
