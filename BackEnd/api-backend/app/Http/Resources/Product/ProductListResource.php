<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'category' => $this->resource->category->name,
            'quantity' => $this->resource->quantity,
        ];
    }
}
