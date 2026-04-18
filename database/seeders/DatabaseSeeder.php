<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BannerSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ContactSeeder::class,
            MenuSeeder::class,
            OrderSeeder::class,
            OrderdetailSeeder::class,
            PostSeeder::class,
            ProductSeeder::class,
            TopicSeeder::class,
            UserSeeder::class,
        ]);
    }
}