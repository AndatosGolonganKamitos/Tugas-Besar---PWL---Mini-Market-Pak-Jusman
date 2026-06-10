<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [

            [
                'code' => 'SUP-002',
                'name' => 'PT Indofood Sukses Makmur',
                'phone' => '02112345678',
                'email' => 'indofood@gmail.com',
                'address' => 'Jakarta',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-003',
                'name' => 'PT Wings Food',
                'phone' => '02187654321',
                'email' => 'wings@gmail.com',
                'address' => 'Jakarta',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-004',
                'name' => 'PT Mayora Indah',
                'phone' => '02155555555',
                'email' => 'mayora@gmail.com',
                'address' => 'Tangerang',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-005',
                'name' => 'PT Ultrajaya',
                'phone' => '02144444444',
                'email' => 'ultrajaya@gmail.com',
                'address' => 'Bandung',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-006',
                'name' => 'PT Aqua Golden Mississippi',
                'phone' => '02133333333',
                'email' => 'aqua@gmail.com',
                'address' => 'Bekasi',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-007',
                'name' => 'PT Orang Tua Group',
                'phone' => '02122222222',
                'email' => 'ot@gmail.com',
                'address' => 'Jakarta',
                'is_active' => true,
            ],

            [
                'code' => 'SUP-008',
                'name' => 'PT Garudafood',
                'phone' => '02111111111',
                'email' => 'garudafood@gmail.com',
                'address' => 'Jakarta',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {

            Supplier::create($supplier);

        }
    }
}