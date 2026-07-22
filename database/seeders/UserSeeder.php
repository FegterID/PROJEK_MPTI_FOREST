<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Setara block admin di database/seed.sql lama.
 * Default admin: username 'admin', email admin@septyaa.com, password admin123.
 * Ditambah 1 akun customer demo biar fitur booking/cart ada contoh datanya.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@septyaa.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'name' => 'Administrator',
                'address' => '-',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'username' => '081234567890',
                'password' => Hash::make('user123'),
                'role' => 'customer',
                'name' => 'Sinta Permata',
                'address' => 'Jl. Kenanga No. 5, Jakarta',
            ]
        );
    }
}
