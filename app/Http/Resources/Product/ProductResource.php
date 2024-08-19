<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ProductReview\ProductReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'rating' => $this->rating(),
            'price' => $this->price,
            'count' => $this->count,
            'images' => $this->imagesList(),
            'reviews' => ProductReviewResource::collection($this->reviews),
        ];
    }
}
