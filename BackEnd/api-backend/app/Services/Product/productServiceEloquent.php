<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Collection;

class ProductServiceEloquent implements ProductService
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getRepository(): ProductRepository
    {
        return $this->productRepository;
    }

    public function getAll(): Collection
    {
        return $this->productRepository->get();
    }


    public function getProductSell(): Collection
    {
        return $this->productRepository
            ->where('discount', '>', 20)
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getProductOther(): Collection
    {
        return $this->productRepository
            ->inRandomOrder()
            ->take(4)
            ->get();
    }
    public function createProduct(array $abttribute): ?Product
    {
        return $this->productRepository->create($abttribute);
    }

    public function getProductSpecial(): Collection
    {
        return $this->productRepository
            ->where('sold', '>', 250)
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getProductByCategoryId(int $id): Collection
    {
        return $this->productRepository
            ->where('category_id', $id)->get();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository
            ->where('id', $id)->first();
    }
    public function updateProduct(int $id, array $attributes): mixed
    {
        return $this->productRepository->update($attributes, $id);
    }

    public function deleteProduct(int $id): ?bool
    {
        return $this->productRepository->delete($id);
    }
}
