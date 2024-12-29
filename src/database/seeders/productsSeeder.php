<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Products;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        //Get all categories
        $categories = Category::all();

        //Create 3 products for each category
        $categories->each(function ($category) {
            Products::factory()->count(3)->create([
                'category_id' => $category->id,
            ]);
        });
    }
}
