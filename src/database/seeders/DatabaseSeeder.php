<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Delete stored images
        if (file_exists(public_path('storage/products'))) {
            \File::deleteDirectory(public_path('storage/products'));
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
