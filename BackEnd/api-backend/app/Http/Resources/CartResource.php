<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductCardResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $color = $this->resource->color;
        $selecteColor = $this->products->productVariants->Where('color', $color)->first();
        $image = $this->resource->products->productVariants->first();

        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'image' => $image->image,
            'name' => $this->products->name,
            'color' => $selecteColor->color,
            'price' => $this->products->price,
            'product_id' => $this->products->id,
        ];
    }
}
