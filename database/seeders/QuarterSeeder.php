<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quarters')->insert([
            ['id' => 1, 'year_id' => 1, 'quarter' => 'Q1', 'created_at' => '2025-01-29 07:00:15', 'updated_at' => '2025-01-29 07:00:15'],
            ['id' => 2, 'year_id' => 1, 'quarter' => 'Q2', 'created_at' => '2025-01-29 07:00:29', 'updated_at' => '2025-01-29 07:00:29'],
            ['id' => 3, 'year_id' => 1, 'quarter' => 'Q3', 'created_at' => '2025-01-29 07:00:36', 'updated_at' => '2025-01-29 07:00:36'],
            ['id' => 4, 'year_id' => 1, 'quarter' => 'Q4', 'created_at' => '2025-01-29 07:00:42', 'updated_at' => '2025-01-29 07:00:42'],
        ]);
    }
}
