<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Collection;

interface ProductService
{
    public function getRepository(): ProductRepository;

    public function getAll(): Collection;

    public function getProductSpecial(): Collection;

    public function getProductSell(): Collection;


    public function getProductOther(): Collection;

    public function getProductByCategoryId(int $id): Collection;

    public function createProduct(array $abttribute): ?Product;

    public function getProductById(int $id): ?Product;

    public function updateProduct(int $id, array $attributes): mixed;

    public function deleteProduct(int $id): ?bool;
}
