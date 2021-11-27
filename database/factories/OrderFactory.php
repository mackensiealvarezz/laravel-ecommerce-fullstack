<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
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
            'inventory_id' => Inventory::factory(),
            'street_address' => $this->faker->streetAddress(),
            'apartment' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => 'NY',
            'country_code'  => 'US',
            'zip' => '12345',
            'email' => $this->faker->email(),
            'name' => $this->faker->name(),
            'order_status' => 'Open',
            'payment_ref' => $this->faker->uuid(),
            'transaction_id' => $this->faker->uuid(),
            'payment_amt_cents' => $this->faker->randomNumber(2),
            'ship_charged_cents' => $this->faker->randomNumber(2),
            'ship_cost_cents' => $this->faker->randomNumber(2),
            'subtotal_cents' => $this->faker->randomNumber(2),
            'total_cents' => $this->faker->randomNumber(2),
            'shipper_name' => 'UPS',
            'payment_date' => now(),
            'shipped_date' => now(),
            'tracking_number' => $this->faker->uuid(),
            'tax_total_cents' => $this->faker->randomNumber(2),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }


}
