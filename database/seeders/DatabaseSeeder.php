<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            Roleseeder::class,
            CategorySeeder::class,
            ItemSeeder::class,
            UserSeeder::class,
        ]);
    }
}

