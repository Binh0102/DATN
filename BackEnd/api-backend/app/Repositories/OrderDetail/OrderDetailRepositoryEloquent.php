<?php

namespace App\Repositories\OrderDetail;

use App\Models\OrderDetail;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderDetailRepositoryEloquent extends BaseRepository implements OrderDetailRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return OrderDetail::class;
    }
}
