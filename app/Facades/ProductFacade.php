<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Product[] published(array $fields = ['id','name','price'])
 * @method static \App\Models\Product store(\App\Services\Product\DTO\CreateProductDto $dto)
 * @method static \App\Services\Product\ProductService setProduct(Product $product)
 *
 * @see \App\Services\Product\ProductService
 */
class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product';
    }
}
