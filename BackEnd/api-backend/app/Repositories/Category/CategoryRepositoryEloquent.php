<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }
}
