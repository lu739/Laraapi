<?php

namespace App\Http\Controllers\Api\Product;

use App\Facades\ProductFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\StoreProductReviewRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Http\Resources\Product\MinifiedProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductReview\ProductReviewResource;
use App\Models\Product;
use App\Services\Product\DTO\CreateProductDto;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin', only: ['store', 'update', 'destroy']),
            new Middleware('draft', only: ['show']),
        ];
    }

/*    public function index(ProductService $service)
    {
        $products = $service->published();

        return MinifiedProductResource::collection($products);
    }    */
    public function index()
    {
        $products = ProductFacade::published();

        return MinifiedProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product)->resolve();
    }

    public function store(StoreProductRequest $request)
    {
        $dto = CreateProductDto::from($request);

        $product = ProductFacade::store($dto);

        return responseOk(201, ['id' => $product->id]);
    }

    public function update(UpdateProductRequest $request, Product $product, ProductService $service)
    {
        $product = $service->setProduct($product)->update($request);

        return ProductResource::make($product)->resolve();
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return responseOk(200);
    }

    public function addReview(StoreProductReviewRequest $request, Product $product, ProductService $service)
    {
        $review = $service->setProduct($product)->addReview($request);

        return ProductReviewResource::make($review)->resolve();
    }
}
