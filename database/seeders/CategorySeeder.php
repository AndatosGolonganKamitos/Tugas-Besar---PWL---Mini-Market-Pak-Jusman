<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan',
            'Minuman',
            'Snack',
            'Perawatan Tubuh',
            'Kebersihan Rumah',
        ];

        foreach ($categories as $i => $category) {

            Category::create([
                'code' => 'CAT-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'name' => $category,
                'is_active' => true,
            ]);

        }
    }
}