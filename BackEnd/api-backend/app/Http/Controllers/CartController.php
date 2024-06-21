<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\CartResource;
use App\Services\Cart\CartService;
use App\Services\Product\ProductService;
use App\Traits\APIResponseTrait;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use APIResponseTrait;
    public function __construct(
        protected CartService $cartService,
        protected ProductService $productService
    ) {
    }

    public function getCartByUserId(): JsonResponse
    {
        try {
            $data = $this->cartService->getCartByUserId();

            return $this->successResponse(CartResource::collection($data), 'successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function deleteProduct(int $id): JsonResponse
    {
        try {
            $data = $this->cartService->deleteProduct($id);

            return $this->successResponse($data, 'Register successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function addToCart(CartRequest $request): JsonResponse
    {
        try {
            $params = $request->validated();
            $carts = $this->cartService->getCartByUserId();
            foreach ($carts as $cart) {
                if ($cart->product_id == $params['product_id'] && $cart->color == $params['color']) {
                    return $this->errorResponse($cart, 'existed', 409);
                }
            }
            $data = $this->cartService->addToCart($params);
            return $this->successResponse($data, 'Register successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }
}
