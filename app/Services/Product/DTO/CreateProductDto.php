<?php

namespace App\Services\Product\DTO;

use App\Enum\ProductStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateProductDto extends Data
{
    public string $name;
    public string|Optional $description;
    public int|float $price;
    public int $count;
    public ProductStatus $status;
    public array|Optional $images;
}
