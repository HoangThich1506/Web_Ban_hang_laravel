<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('brand')->insert([
                'name' => 'Brand ' . $i,
                'slug' => 'brand-' . $i,
                'sort_order' => $i,
                'description' => 'Mô tả thương hiệu ' . $i,
                'image' => 'brand' . $i . '.png',
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
