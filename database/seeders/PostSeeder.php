<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('post')->insert([
                'topic_id' => rand(1,5),
                'title' => 'Bài viết ' . $i,
                'slug' => 'bai-viet-' . $i,
                'detail' => 'Nội dung bài viết ' . $i,
                'image' => 'post' . $i . '.png',
                'post_type' => $i % 2 == 0 ? 'post' : 'page',
                'description' => 'Mô tả bài viết ' . $i,
                'created_by' => 1,
                'updated_by' => null,
                'status' => rand(1,2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
