<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => $this->faker->randomNumber(),
            'color' => $this->faker->colorName(),
            'size' => 'S',
            'weight'  =>  $this->faker->randomNumber(2),
            'price_cents' =>$this->faker->randomNumber(2),
            'sale_price_cents' => $this->faker->randomNumber(2),
            'cost_cents' => $this->faker->randomNumber(2),
            'sku' => $this->faker->word(),
            'length' => $this->faker->randomNumber(2),
            'height' => $this->faker->randomNumber(2),
            'width' => $this->faker->randomNumber(2),
            'note' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }


}
