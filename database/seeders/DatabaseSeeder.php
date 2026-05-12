<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['code' => 'CBG-001', 'name' => 'Cabang Pusat', 'address' => 'Jl. Merdeka No. 1, Jakarta', 'phone' => '021-1234567'],
            ['code' => 'CBG-002', 'name' => 'Cabang Bandung', 'address' => 'Jl. Asia Afrika No. 45, Bandung', 'phone' => '022-7654321'],
            ['code' => 'CBG-003', 'name' => 'Cabang Surabaya', 'address' => 'Jl. Tunjungan No. 12, Surabaya', 'phone' => '031-9876543'],
            ['code' => 'CBG-004', 'name' => 'Cabang Medan', 'address' => 'Jl. Sudirman No. 78, Medan', 'phone' => '061-4567890'],
            ['code' => 'CBG-005', 'name' => 'Cabang Makassar', 'address' => 'Jl. Sam Ratulangi No. 23, Makassar', 'phone' => '0411-234567'],
        ];

        foreach ($branches as $data) {
            Branch::create($data);
        }

        User::factory()->create([
            'name' => 'Owner Minimarket',
            'email' => 'owner@minimarket.com',
            'role' => 'owner',
            'branch_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Manajer Pusat',
            'email' => 'manager@minimarket.com',
            'role' => 'manager',
            'branch_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@minimarket.com',
            'role' => 'supervisor',
            'branch_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Kasir Pusat',
            'email' => 'kasir@minimarket.com',
            'role' => 'cashier',
            'branch_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Gudang Pusat',
            'email' => 'gudang@minimarket.com',
            'role' => 'warehouse',
            'branch_id' => 1,
        ]);
    }
}
