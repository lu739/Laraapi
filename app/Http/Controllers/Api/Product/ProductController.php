<?php

namespace App\Http\Controllers\Api\Product;

use App\Enum\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->select(['id','name','price'])
            ->whereStatus(ProductStatus::PUBLISHED)
            ->get();

        $products = $products->map(fn($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'rating' => $product->rating(),
        ]);

        return $products;
    }

    public function show(Product $product)
    {
        if ($product->status === ProductStatus::DRAFT) {
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'rating' => $product->rating(),
            'price' => $product->price,
            'count' => $product->count,
            'images' => $product->images()->get(),
            'reviews' => $product->reviews->map(fn($review) => [
                'id' => $review->id,
                'userName' => $review->user->name,
                'rating' => $review->rating,
                'text' => $review->text,
            ]),
        ];
    }
}
