<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $variant = $this->resource->product->productVariants->first();
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'image' => $variant->image,
            'color' => $variant->color,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'product_id' => $this->product->id,
        ];
    }
}
