<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function getAllCategories(array $filters)
    {
        return $this->category->all($filters);
    }

    public function findCategoryById(string $id)
    {
        return $this->category->find($id);
    }

    public function createCategory(array $data)
    {
        return $this->category->create($data);
    }

    public function updateCategory(array $data, string $id)
    {
        return $this->category->update($data, $id);
    }

    public function deleteCategory(string $id)
    {
        return $this->category->delete($id);
    }
}
