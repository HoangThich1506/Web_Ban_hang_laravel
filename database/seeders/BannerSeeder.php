<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('banner')->insert([
                'name' => 'Banner ' . $i,
                'link' => 'https://localhost:8000/banner-' . $i,
                'sort_order' => $i,
                'position' => $i % 2 == 0 ? 'slideshow' : 'advertise',
                'description' => 'Mô tả banner ' . $i,
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}