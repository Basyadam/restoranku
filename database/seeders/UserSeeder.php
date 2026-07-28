<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun demo untuk testing
        $adminRole = Role::where('role_name', 'admin')->first();
        $cashierRole = Role::where('role_name', 'cashier')->first();
        $chefRole = Role::where('role_name', 'chef')->first();
        $customerRole = Role::where('role_name', 'customer')->first();

        if ($adminRole) {
            User::create([
                'username' => 'admin',
                'password' => Hash::make('password'),
                'fullname' => 'Administrator',
                'email' => 'admin@restoranku.test',
                'phone' => '081234567890',
                'role_id' => $adminRole->id,
            ]);
        }

        if ($cashierRole) {
            User::create([
                'username' => 'kasir',
                'password' => Hash::make('password'),
                'fullname' => 'Kasir Restoranku',
                'email' => 'kasir@restoranku.test',
                'phone' => '081234567891',
                'role_id' => $cashierRole->id,
            ]);
        }

        if ($chefRole) {
            User::create([
                'username' => 'chef',
                'password' => Hash::make('password'),
                'fullname' => 'Chef Restoranku',
                'email' => 'chef@restoranku.test',
                'phone' => '081234567892',
                'role_id' => $chefRole->id,
            ]);
        }

        if ($customerRole) {
            User::create([
                'username' => 'customer',
                'password' => Hash::make('password'),
                'fullname' => 'Pelanggan Restoranku',
                'email' => 'customer@restoranku.test',
                'phone' => '081234567893',
                'role_id' => $customerRole->id,
            ]);
        }
    }
}
