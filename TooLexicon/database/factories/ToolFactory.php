<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tool>
 */
class ToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'official_name' => fake()->word(),
            'user_id' => User::factory(),   // あってもなくてもOK
            'category'      => fake()->randomElement(['切削', '締結', '測定', '研磨']),
            'usage'         => fake()->sentence(),
            'safety_notes'  => fake()->sentence(),
            'amazon_url'    => 'https://www.amazon.co.jp/',
            'monotaro_url'  => 'https://www.monotaro.com/',
        ];
    }
}
