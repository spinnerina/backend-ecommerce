<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Delete the directory for the images if it exists
        if (Storage::exists('public/products')){
            Storage::deleteDirectory('public/products');
        }

        //Create the directory for the images
        Storage::makeDirectory('public/products');

        //Call the seeder to add categories and products
        $this->call([
            CategorySeeder::class,
            ProductsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
