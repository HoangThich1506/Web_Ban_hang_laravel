<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('category')->insert([
                'name' => 'Category ' . $i,
                'slug' => 'category-' . $i,
                'image' => 'category' . $i . '.png',
                'parent_id' => 0,
                'sort_order' => $i,
                'description' => 'Mô tả loại sản phẩm ' . $i,
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
