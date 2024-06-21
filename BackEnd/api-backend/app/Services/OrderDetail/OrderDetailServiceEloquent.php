<?php

namespace App\Services\OrderDetail;

use App\Models\OrderDetail;
use App\Repositories\OrderDetail\OrderDetailRepository;

class OrderDetailServiceEloquent implements OrderDetailService
{
    /**
     * @return OrderRepository
     */

    public function __construct(protected OrderDetailRepository $orderDetailRepository)
    {
    }
    public function getRepository(): OrderDetailRepository
    {
        return $this->orderDetailRepository;
    }
    public function addOrderDetail(array $attribute): ?OrderDetail
    {
        return $this->orderDetailRepository->create($attribute);
    }
}
