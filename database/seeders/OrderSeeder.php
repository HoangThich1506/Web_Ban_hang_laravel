<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('order')->insert([
                'user_id' => rand(1,5),
                'name' => 'Khách hàng ' . $i,
                'phone' => '09000000'.$i,
                'email' => 'khach'.$i.'@gmail.com',
                'address' => 'TP HCM',
                'note' => 'Ghi chú đơn hàng '.$i,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => rand(1,2),
            ]);
        }
    }
}
