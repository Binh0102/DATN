<?php

namespace App\Services\ProductVariant;

use App\Models\ProductVariant;
use App\Repositories\ProductVariant\ProductVariantRepository;

class ProductVariantServiceEloquent implements ProductVariantService
{
    public function __construct(protected ProductVariantRepository $productVariantRepository)
    {
    }

    public function getRepository(): ProductVariantRepository
    {
        return $this->productVariantRepository;
    }

    public function createProductVariant(array $attributes): ?ProductVariant
    {
        return $this->productVariantRepository->create($attributes);
    }

    public function deleteProductVariant(int $id): bool
    {
        return $this->productVariantRepository->delete($id);
    }
    public function deleteProductVariants(int $id): bool
    {
        return $this->productVariantRepository->where('product_id', $id)->delete($id);
    }

    public function updateProductVariant(int $id, array $attributes): ?ProductVariant
    {
        return $this->productVariantRepository->update($attributes, $id);
    }
}
