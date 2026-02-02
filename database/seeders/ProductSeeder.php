<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // create 24 products (matching ProductFactory array)
        Product::factory()->count(24)->create();
    }
}
