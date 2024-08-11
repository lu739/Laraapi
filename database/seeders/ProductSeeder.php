<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::factory(10)
            ->create()
            ->each(function (\App\Models\Product $product) {
                $numImages = rand(0, 5); // Генерируем случайное количество изображений от 0 до 5

                for ($i = 0; $i < $numImages; $i++) {
                    $product->images()->create([
                        'path' => fake()->imageUrl()
                    ]);
                }
            });

    }
}
