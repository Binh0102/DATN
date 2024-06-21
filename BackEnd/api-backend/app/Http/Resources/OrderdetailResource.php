<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderdetailResource extends JsonResource
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
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'sold' => $this->resource->sold,
            'image' => ProductVariantResource::collection($this->resource->productVariants)->pluck('image')->first(),
            'color' => ProductVariantResource::collection($this->resource->productVariants)->pluck('color')->first(),
            'quantity' => $this->pivot->quantity,
            'color' => $this->pivot->color,
        ];
    }
}
