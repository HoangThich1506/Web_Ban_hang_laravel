<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('menu')->insert([
                'name' => 'Menu ' . $i,
                'link' => '/menu-'.$i,
                'table_id' => null,
                'type' => 'custom',
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
