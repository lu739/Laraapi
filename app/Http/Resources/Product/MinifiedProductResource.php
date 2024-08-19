<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ProductReview\ProductReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class MinifiedProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => $this->rating(),
            'price' => $this->price,
        ];
    }
}
