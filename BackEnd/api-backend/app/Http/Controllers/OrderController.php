<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Order\OrderDetailResource;
use App\Http\Resources\Order\OrderListResource;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Order\OrderService;
use App\Services\OrderDetail\OrderDetailService;
use App\Services\Product\ProductService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected OrderService $orderService, protected OrderDetailService $orderDetailService, protected CartService $cartService, protected ProductService $productService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            $data = $this->orderService->getAll();
            return $this->successResponse(OrderListResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getOrderByUser(): JsonResponse
    {
        try {
            $data = $this->orderService->getOrderByUser();
            return $this->successResponse(OrderListResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
    public function getOrderByStatus(int $status): JsonResponse
    {
        try {
            $data = $this->orderService->getOrderByStatus($status);
            return $this->successResponse(OrderListResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function createOrder(OrderRequest $request): JsonResponse
    {
        try {
            $params = $request->validated();
            $params['status'] = 1;
            $data = $this->orderService->createOrder($params);
            $this->createOrderDetail($data, $params);
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    private function createOrderDetail(Order $order, mixed $request): void
    {
        $data['order_id'] = $order->id;
        if ($request['orderDetails']) {
            foreach ($request['orderDetails'] as $orderDetail) {
                $data['product_id'] = $orderDetail['product_id'];
                $data['quantity'] = $orderDetail['quantity'];
                $this->orderDetailService->addOrderDetail($data);
                $this->cartService->deleteProductOrder($data['product_id']);
                $product = $this->productService->getProductById($data['product_id']);
                $params['quantity'] = $product->quantity - $data['quantity'];
                $this->productService->updateProduct($data['product_id'], $params);
            }
        }
    }

    public function getOrderById(int $id): JsonResponse
    {
        try {
            $data = $this->orderService->getOrderById($id);
            return $this->successResponse(new OrderDetailResource($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        try {
            $params = $request->validated();
            $data = $this->orderService->updateStatus($id, $params);
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
