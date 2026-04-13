<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'role' => 'superadmin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Operator',
            'username' => 'operator',
            'role' => 'operator',
            'password' => Hash::make('password'),
        ]);

        for($i=1; $i<=10; $i++) {
            Product::create([
                'kode' => 'BRG' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama' => 'Produk ' . $i,
                'harga' => 15000 + ($i * 2000),
                'stok' => 50
            ]);
        }
    }
}
