<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderServiceEloquent implements OrderService
{
    public function __construct(protected OrderRepository $orderRepository)
    {
    }

    public function getRepository(): OrderRepository
    {
        return $this->orderRepository;
    }

    public function getAll(): Collection
    {
        return $this->orderRepository->get();
    }

    public function getOrderByid(int $id): ?Order
    {
        return $this->orderRepository->where('id', $id)->first();
    }

    public function getOrderByUser(): Collection
    {
        $user = Auth::user();
        return $this->orderRepository->where('user_id', $user->id)->get();
    }

    public  function createOrder(array $abttribute): ?Order
    {
        return $this->orderRepository->create($abttribute);
    }

    public function getOrderByStatus(int $status): ?Collection
    {
        return $this->orderRepository->where('status', $status)->get();
    }

    public function updateStatus(int $id, array $status): ?Order
    {
        return $this->orderRepository->update($status, $id);
    }
}
