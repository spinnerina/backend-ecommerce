<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductsFactory extends Factory
{
    public function definition()
    {
        $image = $this->faker->image('public/storage/products', 640, 480, null, false);
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::all()->random()->id,
            'image' => $image ? 'products/' . $image : null,
        ];
    }
}
