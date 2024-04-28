<?php

namespace Database\Factories\Product;

use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productData  = Product::get()->random(1);

        return [
            'count'       => fake()->numberBetween(1, 100),
            'total_price' => fake()->numberBetween(1000, 99999999),
            'products'    => [
                'id'    => $productData[0]['_id'],
                'name'  => $productData[0]['name'],
                'price' => $productData[0]['price'],
            ],

        ];
    }

}
