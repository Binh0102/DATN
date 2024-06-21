<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryServiceEloquent implements CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

    public function getAll(): Collection
    {
        return $this->categoryRepository->get();
    }

    public function getNameCategory(int $id): ?Category
    {
        return $this->categoryRepository
            ->where('id', $id)->first();
    }
}
