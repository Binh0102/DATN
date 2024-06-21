<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardResource extends JsonResource
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
            'discount' => $this->resource->discount,
            'sold' => $this->resource->sold,
            'image' => ProductVariantResource::collection($this->resource->productVariants)->pluck('image')->first(),
            'color' => ProductVariantResource::collection($this->resource->productVariants)->pluck('color')->first(),
        ];
    }
}
