<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Collection;

interface CartService
{
    public function getRepository(): CartRepository;


    public function getCartByUserId(): Collection;

    public function deleteProduct(int $id): bool;

    public function deleteProductOrder(int $id): bool;

    public function addToCart(array $abttribute): ?Cart;
}
