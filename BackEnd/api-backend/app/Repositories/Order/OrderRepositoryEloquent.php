<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return Order::class;
    }
}
