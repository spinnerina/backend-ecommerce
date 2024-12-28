<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category;

class categorySeeder extends Seeder
{
    public function run()
    {
        category::factory()->count(5)->create();
    }
}
