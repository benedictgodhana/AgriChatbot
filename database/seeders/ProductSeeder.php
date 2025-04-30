<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy manufacturer (if not already seeded elsewhere)
        $manufacturer = Manufacturer::firstOrCreate([
            'name' => 'AgriGrow Ltd'
        ]);

        // List of products to seed
        $products = [
            [
                'name' => 'Hybrid Maize Seeds',
                'description' => 'High-yield maize seeds ideal for most Kenyan regions.',
                'price' => 3500.00,
                'stock_quantity' => 150,
                'manufacturer_id' => $manufacturer->id,
            ],
            [
                'name' => 'DAP Fertilizer 50kg',
                'description' => 'Effective fertilizer for planting season.',
                'price' => 4500.00,
                'stock_quantity' => 100,
                'manufacturer_id' => $manufacturer->id,
            ],
            [
                'name' => 'Organic Neem Pesticide',
                'description' => 'Natural pesticide safe for vegetables.',
                'price' => 800.00,
                'stock_quantity' => 75,
                'manufacturer_id' => $manufacturer->id,
            ],
        ];

        // Insert products into the database
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
