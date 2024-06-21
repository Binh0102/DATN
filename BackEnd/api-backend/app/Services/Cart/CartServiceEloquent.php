<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartServiceEloquent implements CartService
{
    public function __construct(protected CartRepository $cartRepository)
    {
    }
    public function getRepository(): CartRepository
    {
        return $this->cartRepository;
    }
    public function getCartByUserId(): Collection
    {
        $user = Auth::user();
        return $this->cartRepository
            ->where('user_id', $user->id)
            ->get();
    }

    public function deleteProduct(int $id): bool
    {
        return $this->cartRepository
            ->where('id', $id)
            ->delete();
    }

    public function deleteProductOrder(int $id): bool
    {
        return $this->cartRepository
            ->where('product_id', $id)
            ->delete();
    }

    public function addToCart(array $attribute): ?Cart
    {
        $user = Auth::user();
        $attribute['user_id'] = $user->id;
        return $this->cartRepository->create($attribute);
    }
}
