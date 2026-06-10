<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
        {
            $products = [

                'Makanan' => [
                    'Indomie Goreng',
                    'Indomie Soto',
                    'Mie Sedaap',
                    'ABC Soto',
                ],

                'Minuman' => [
                    'Aqua 600ml',
                    'Le Minerale',
                    'Pocari Sweat',
                    'Mizone',
                ],

                'Snack' => [
                    'Chitato',
                    'Qtela',
                    'Tango',
                    'Beng Beng',
                ],

                'Perawatan Tubuh' => [
                    'Pepsodent',
                    'Close Up',
                    'Lifebuoy',
                ],

                'Kebersihan Rumah' => [
                    'Rinso',
                    'Molto',
                    'Sunlight',
                ],
            ];

            $counter = 1;

            foreach ($products as $categoryName => $items) {

                $category = \App\Models\Category::where(
                    'name',
                    $categoryName
                )->first();

                foreach ($items as $item) {

                    Product::create([

                        'code' => 'PRD-' . str_pad($counter++, 4, '0', STR_PAD_LEFT),

                        'name' => $item,

                        'category_id' => $category->id,

                        'purchase_price' => rand(1000, 10000),

                        'selling_price' => rand(12000, 30000),

                        'stock' => rand(5, 100),

                        'is_active' => true,

                    ]);
                }
            }
        }
}