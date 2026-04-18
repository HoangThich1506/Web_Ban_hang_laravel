<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('product')->insert([
                'category_id' => rand(1,5),
                'brand_id' => rand(1,5),
                'name' => 'Product ' . $i,
                'slug' => 'product-' . $i,
                'price_buy' => rand(1000000,5000000),
                'price_sale' => rand(800000,4500000),
                'image' => 'product' . $i . '.png',
                'qty' => rand(10,100),
                'detail' => 'Chi tiết sản phẩm ' . $i,
                'description' => 'Mô tả sản phẩm ' . $i,
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
