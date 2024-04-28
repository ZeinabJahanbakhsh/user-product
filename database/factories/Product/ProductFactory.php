<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => 'product_' . fake()->name,
            'price'     => fake()->randomFloat('3', '100', '999.000.000') . '.000',
            'inventory' => [
                'quantity'    => fake()->numberBetween(1, 10),
                'description' => fake()->text('1000'),
            ]
        ];
    }
}
