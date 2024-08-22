<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected function setUp(): void
    {
        parent::setUp();

        Product::factory(5)
            ->for(User::factory())
            ->create();
    }

    public function test_get_products(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'rating',
                ]
            ]
        ]);
    }
}
