<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Product::class;
    }
}
