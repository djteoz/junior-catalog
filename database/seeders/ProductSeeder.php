<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // create 40 products spread across categories
        Product::factory()->count(40)->create();
    }
}
