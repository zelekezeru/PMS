<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FortnightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fortnights')->insert([
            ['id' => 1, 'quarter_id' => 1, 'start_date' => '2025-01-06', 'end_date' => '2025-01-19', 'created_at' => '2025-01-29 07:01:37', 'updated_at' => '2025-01-29 07:01:37'],
            ['id' => 2, 'quarter_id' => 1, 'start_date' => '2025-01-20', 'end_date' => '2025-02-02', 'created_at' => '2025-01-29 07:03:29', 'updated_at' => '2025-01-29 07:19:37'],
            ['id' => 3, 'quarter_id' => 1, 'start_date' => '2025-02-03', 'end_date' => '2025-02-16', 'created_at' => '2025-01-29 07:14:19', 'updated_at' => '2025-01-29 07:21:04'],
            ['id' => 4, 'quarter_id' => 1, 'start_date' => '2025-02-17', 'end_date' => '2025-03-03', 'created_at' => '2025-01-29 07:20:11', 'updated_at' => '2025-01-29 07:20:11'],
            ['id' => 5, 'quarter_id' => 2, 'start_date' => '2025-03-04', 'end_date' => '2025-03-15', 'created_at' => '2025-01-29 07:01:37', 'updated_at' => '2025-01-29 07:01:37'],
            ['id' => 6, 'quarter_id' => 2, 'start_date' => '2025-03-16', 'end_date' => '2025-03-30', 'created_at' => '2025-01-29 07:03:29', 'updated_at' => '2025-01-29 07:19:37'],
            ['id' => 7, 'quarter_id' => 2, 'start_date' => '2025-04-01', 'end_date' => '2025-04-14', 'created_at' => '2025-01-29 07:14:19', 'updated_at' => '2025-01-29 07:21:04'],
            ['id' => 8, 'quarter_id' => 2, 'start_date' => '2025-04-15', 'end_date' => '2025-04-30', 'created_at' => '2025-01-29 07:20:11', 'updated_at' => '2025-01-29 07:20:11'],
            ['id' => 9, 'quarter_id' => 2, 'start_date' => '2025-05-01', 'end_date' => '2025-05-15', 'created_at' => '2025-01-29 07:20:11', 'updated_at' => '2025-01-29 07:20:11'],
        ]);
    }
}
