<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderdetailResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'user_id' => $this->resource->user_id,
            'address' => $this->resource->address,
            'total' => $this->resource->total,
            'status' => $this->resource->status,
            'nameProduct' => ProductResource::collection($this->resource->orderDetails)->pluck('name')->first(),
            'nameUser' => $this->user->name,
            'phone' => $this->user->phone,
            'time' => $this->resource->created_at,
        ];
    }
}
