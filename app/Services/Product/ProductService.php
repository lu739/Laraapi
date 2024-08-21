<?php

namespace App\Services\Product;

use App\Enum\ProductStatus;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\StoreProductReviewRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public Product $product;

    public function setProduct(Product $product): ProductService
    {
        $this->product = $product;
        return $this;
    }
    public function published($fields = ['id','name','price']): Collection
    {
        return Product::query()
            ->select($fields)
            ->whereStatus(ProductStatus::PUBLISHED)
            ->get();
    }

    public function store(StoreProductRequest $request): Product
    {
        $product = auth()->user()->products()->create([
            'name' => $request->str('name'),
            'description' => $request->str('description'),
            'price' => $request->input('price'),
            'count' => $request->integer('count'),
            'status' => $request->enum('status', ProductStatus::class),
        ]);

        foreach ($request->images as $image) {
            $product->images()->create([
                'path' => config('app.url') . Storage::url($image->storePublicly('images')),
            ]);
        }

        return $product;
    }

    public function update(UpdateProductRequest $request)
    {
        if ($request->method() === 'PUT') {
            $this->product->update([
                'name' => $request->input('name') ?? null,
                'description' => $request->input('description') ?? null,
                'price' => $request->input('price') ?? null,
                'count' => $request->input('count') ?? null,
                'status' => $request->enum('status', ProductStatus::class),
            ]);
        } else {
            $this->product->update(
                $request->only('name', 'description', 'price', 'count', 'status')
            );
        }

        return $this->product;
    }

    public function addReview(StoreProductReviewRequest $request)
    {
        return $this->product->reviews()->create([
            'user_id' => auth()->id(),
            'text' => $request->str('text'),
            'rating' => $request->integer('rating'),
        ]);
    }
}
