<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use Prettus\Repository\Eloquent\BaseRepository;

class CartRepositoryEloquent extends BaseRepository implements CartRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return Cart::class;
    }
}
