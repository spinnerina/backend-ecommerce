<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class categoryFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
