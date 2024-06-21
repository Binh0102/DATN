<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'description' => $this->resource->description,
            'image' => ProductVariantResource::collection($this->resource->productVariants)->pluck('image')->first(),
            'variants' => ProductVariantResource::collection($this->resource->productVariants),
            'comments' => CommentResource::collection($this->resource->comments),
            'category' => $this->resource->category->name,
            'category_id' => $this->resource->category_id,
            'quantity' => $this->resource->quantity,
        ];
    }
}
