<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Collection;

interface OrderService
{
    /**
     * @return OrderRepository
     */
    public function getRepository(): OrderRepository;

    public function getAll(): Collection;

    public function getOrderByid(int $id): ?Order;

    public function getOrderByUser(): Collection;

    public  function createOrder(array $abttribute): ?Order;

    public function getOrderByStatus(int $status): ?Collection;

    public function updateStatus(int $id, array $status): ?Order;
}
