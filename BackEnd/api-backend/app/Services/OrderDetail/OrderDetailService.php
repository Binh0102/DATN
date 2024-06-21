<?php

namespace App\Services\OrderDetail;

use App\Models\OrderDetail;
use App\Repositories\OrderDetail\OrderDetailRepository;

interface OrderDetailService
{
    /**
     * @return OrderDetailOrderRepository
     */
    public function getRepository(): OrderDetailRepository;

    public function addOrderDetail(array $attribute): ?OrderDetail;
}
