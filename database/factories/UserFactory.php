<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'shop_name' => $this->faker->company(),
            'shop_domain' => $this->faker->company(),
            'card_brand'  => 'Amex',
            'card_last_four' => $this->faker->randomNumber(4),
            'billing_plan' => 'Startup',
            'trial_ends_at' => now(),
            'trial_starts_at' => now(),
            'superadmin' => 0,
            'is_enabled' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }


}
