<?php

namespace App\Services\ProductVariant;

use App\Models\ProductVariant;
use App\Repositories\ProductVariant\ProductVariantRepository;

interface ProductVariantService
{
    public function getRepository(): ProductVariantRepository;

    public function createProductVariant(array $attributes): ?ProductVariant;

    public function deleteProductVariant(int $id): bool;

    public function deleteProductVariants(int $id): bool;

    public function updateProductVariant(int $id, array $attributes): ?ProductVariant;
}
