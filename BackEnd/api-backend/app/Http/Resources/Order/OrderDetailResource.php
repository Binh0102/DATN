<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderdetailResource as ResourcesOrderdetailResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'nameUser' => $this->user->name,
            'email' => $this->user->email,
            'address' => $this->resource->address,
            'total' => $this->resource->total,
            'status' => $this->resource->status,
            'orderDetails' => ResourcesOrderdetailResource::collection($this->resource->orderDetails),
            'phone' => $this->user->phone,
            'time' => $this->resource->created_at
        ];
    }
}
