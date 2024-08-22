<?php

namespace Tests\Feature\Product;

use App\Enum\ProductStatus;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()
            ->for(User::factory())
            ->has(ProductReview::factory(5)->for(User::factory()), 'reviews')
            ->has(ProductImage::factory(5), 'images')
            ->create(['status' => ProductStatus::PUBLISHED]);
    }

    public function test_get_product(): void
    {
        $response = $this->get(route('products.show', $this->product));

        $response->assertOk();
        $response->assertJsonStructure([
                    'id',
                    'name',
                    'price',
                    'rating',
                    'images',
                    'reviews',
                    'count',
        ]);
        $response->assertJson([
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'rating' => $this->product->rating(),
                    'count' => $this->product->count,
        ]);
    }
}
