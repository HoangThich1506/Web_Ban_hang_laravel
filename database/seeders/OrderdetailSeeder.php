<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $price = rand(1000000,3000000);
            $qty = rand(1,5);

            DB::table('orderdetail')->insert([
                'order_id' => rand(1,10),
                'product_id' => rand(1,20),
                'price' => $price,
                'qty' => $qty,
                'amount' => $price * $qty
            ]);
        }
    }
}
