<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category;
use App\Models\products;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get all categories
        $categories = category::all();

        //Create 3 products for each category
        $categories->each(function ($category) {
            products::factory()->count(3)->create([
                'category_id' => $category->id,
            ]);
        });
    }
}
