<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\products;
use App\Models\category;

class FetchProducts extends Command
{
    
    protected $signature = 'fetch:products';

    protected $description = 'Fetch products from an external API and save them to the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Initiating the process to fetch products from the external API...');

        //Call the external API
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->successful()) {
            $products = $response->json();

            foreach ($products as $productData) {
                //Get a random category ID
                $randomCategoryId = category::inRandomOrder()->value('id');
                if(!$randomCategoryId) {
                    $this->error('No categories found in the database. Please run the seeder to add categories.');
                    return 1;
                }
                //Save the product to the database
                products::Create(
                    [
                        'name' => $productData['title'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => rand(0, 50),
                        'category_id' => $randomCategoryId,
                        'image' => $productData['image'],
                    ]
                );
            }

            $this->info('Products fetched and stored successfully!');
        } else {
            $this->error('Failed to fetch products from the API.');
        }

        return 0;
    }
}
