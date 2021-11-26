<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_id' => User::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'style' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'type'  => $this->faker->word(),
            'url' => $this->faker->url(),
            'shipping_price' => $this->faker->randomNumber(2),
            'note' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }


}
