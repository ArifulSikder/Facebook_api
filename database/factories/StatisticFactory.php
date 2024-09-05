<?php

namespace Database\Factories;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistic>
 */
class StatisticFactory extends Factory
{
    protected $model = Statistic::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => rand(1, 100), // Generates a random page ID (this should be linked to a real Page model in actual usage)
            'total_responses' => $this->faker->numberBetween(0, 1000), // Generates a random number for total responses
        ];
    }
}
