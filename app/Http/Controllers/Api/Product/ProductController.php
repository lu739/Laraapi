<?php

namespace App\Http\Controllers\Api\Product;

use App\Enum\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\StoreProductReviewRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Http\Resources\Product\MinifiedProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin', only: ['store', 'update', 'destroy']),
            new Middleware('draft', only: ['show']),
        ];
    }

    public function index()
    {
        $products = Product::query()
            ->select(['id','name','price'])
            ->whereStatus(ProductStatus::PUBLISHED)
            ->get();

        return MinifiedProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product)->resolve();
    }

    public function store(StoreProductRequest $request)
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

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->method() === 'PUT') {
            $product->update([
                'name' => $request->input('name') ?? null,
                'description' => $request->input('description') ?? null,
                'price' => $request->input('price') ?? null,
                'count' => $request->input('count') ?? null,
                'status' => $request->enum('status', ProductStatus::class),
            ]);
        } else {
            $product->update(
                $request->only('name', 'description', 'price', 'count', 'status')
            );
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'success'
        ],204);
    }

    public function addReview(StoreProductReviewRequest $request, Product $product)
    {
        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'text' => $request->str('text'),
            'rating' => $request->integer('rating'),
        ]);

        return $review->only('id');
    }
}
