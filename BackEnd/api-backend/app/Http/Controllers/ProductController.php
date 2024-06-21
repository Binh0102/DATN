<?php

namespace App\Http\Controllers;

use App\Helper\ImageManagerTrait;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Resources\Product\ProductCardResource;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Image\ImageService;
use App\Services\Product\ProductService;
use App\Services\ProductVariant\ProductVariantService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use APIResponseTrait, ImageManagerTrait;

    public function __construct(
        protected ProductService $productService,
        protected ProductVariantService $productVariantService,
    ) {
    }

    public function getAll(): JsonResponse
    {
        try {
            $data = $this->productService->getAll();
            return $this->successResponse(ProductCardResource::collection($data), 'SuccessFul', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getList(): JsonResponse
    {
        try {
            $data = $this->productService->getAll();
            return $this->successResponse(ProductListResource::collection($data), 'SuccessFul', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getProductOther(): JsonResponse
    {
        try {
            $data = $this->productService->getProductOther();
            return $this->successResponse(ProductCardResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getProductSell(): JsonResponse
    {
        try {
            $data = $this->productService->getProductSell();
            return $this->successResponse(ProductCardResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function createProduct(CreateProductRequest $request): JsonResponse
    {
        try {
            $data = $this->productService->createProduct($request->validated());
            $this->createVariant($data, $request->validated());
            return $this->successResponse($data, 'Ok', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    private function createVariant(Product $product, mixed $request): void
    {
        $attributes['product_id'] = $product->id;
        if ($request['variants']) {
            foreach ($request['variants'] as $variant) {
                $attributes['color'] = $variant['color'];
                if ($variant['image']) {
                    $fileData = $this->uploads($variant['image']);
                    $attributes['image'] = $fileData['path'];
                }
                $this->productVariantService->createProductVariant($attributes);
            }
        }
    }

    public function getProductSpecial(): JsonResponse
    {
        try {
            $data = $this->productService->getProductSpecial();
            return $this->successResponse(ProductCardResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getProductByCategoryId(int $id): JsonResponse
    {
        try {
            $data = $this->productService->getProductByCategoryId($id);
            return $this->successResponse(ProductResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getProductById(int $id): JsonResponse
    {
        try {
            $data = $this->productService->getProductById($id);
            return $this->successResponse(new ProductDetailResource($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updateProduct(EditProductRequest $requests, int $id): JsonResponse
    {
        try {
            $request = $requests->validated();
            $product = $this->productService->getProductById($id);
            $existingVariantIds = $product->productVariants ? $product->productVariants->pluck('id')->toArray() : [];
            if ($request['variants']) {

                $variantIds = array_diff($existingVariantIds, array_column($request['variants'], 'id'));
                foreach ($variantIds as $variantId) {
                    $this->productVariantService->deleteProductVariant($variantId);
                }
            }
            if ($request['variants']) {
                $attributes['product_id'] = $id;
                foreach ($request['variants'] as $variant) {
                    $attributes['color'] = $variant['color'];
                    if (isset($variant['id'])) {
                        if (is_file($variant['image'])) {
                            $fileData = $this->uploads($variant['image']);
                            $attributes['image'] = $fileData['path'];
                        } else {
                            $attributes['image'] = $variant['image'];
                        }
                        $this->productVariantService->updateProductVariant($variant['id'], $attributes);
                    } else {
                        if (is_file($variant['image'])) {
                            $fileData = $this->uploads($variant['image']);
                            $attributes['image'] = $fileData['path'];
                        } else {
                            $attributes['image'] = $variant['image'];
                        }
                        $this->productVariantService->createProductVariant($attributes);
                    }
                }
            }
            $data = $this->productService->updateProduct($id, $request);

            return $this->successResponse(new ProductDetailResource($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function deleteProduct(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);
            $this->productVariantService->deleteProductVariants($id);
            return $this->successResponse("Successful", 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
