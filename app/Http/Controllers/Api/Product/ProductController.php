<?php

namespace App\Http\Controllers\Api\Product;

use App\Enum\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        auth()->login(User::query()->where('is_admin', true)->inRandomOrder()->first());
    }

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
            'images' => $product->images()->get()->map(fn($image) => $image->path),
            'reviews' => $product->reviews->map(fn($review) => [
                'id' => $review->id,
                'userName' => $review->user->name,
                'rating' => $review->rating,
                'text' => $review->text,
            ]),
        ];
    }

    public function store(Request $request)
    {
        $product = auth()->user()->products()->create([
        // $product = Product::query()->create([
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

    public function review(Request $request, Product $product)
    {
        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'text' => $request->str('text'),
            'rating' => $request->integer('rating'),
        ]);

        return $review->only('id');
    }
}
