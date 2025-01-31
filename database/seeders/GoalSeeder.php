<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goals')->insert([
            ['id' => 2, 'strategy_id' => 1, 'name' => 'Start Post Graduate programs at new places (both Amharic and English media)', 'description' => 'Start Post Graduate programs at new places (both Amharic and English media)', 'created_at' => '2025-01-29 03:04:46', 'updated_at' => '2025-01-29 03:04:46'],
            ['id' => 3, 'strategy_id' => 1, 'name' => 'Educate 4151 students and out of which graduate 500 students; and train 1500 local leaders', 'description' => 'Educate 4151 students and out of which graduate 500 students; and train 1500 local leaders', 'created_at' => '2025-01-29 03:05:00', 'updated_at' => '2025-01-29 03:05:00'],
            ['id' => 4, 'strategy_id' => 2, 'name' => 'Increase SITS student body by 1000.', 'description' => 'Increase SITS student body by 1000.', 'created_at' => '2025-01-29 03:05:20', 'updated_at' => '2025-01-29 03:05:20'],
            ['id' => 5, 'strategy_id' => 3, 'name' => 'Increase local revenue by 30%- benchmark 2023 local income.', 'description' => 'Increase local revenue by 30%- benchmark 2023 local income.', 'created_at' => '2025-01-29 03:05:41', 'updated_at' => '2025-01-29 03:05:41'],
            ['id' => 6, 'strategy_id' => 3, 'name' => 'Start New construction at Sodo campus', 'description' => 'Start New construction at Sodo campus', 'created_at' => '2025-01-29 03:05:54', 'updated_at' => '2025-01-29 03:05:54'],
            ['id' => 7, 'strategy_id' => 3, 'name' => 'Improve financial system through digital technology', 'description' => 'Improve financial system through digital technology', 'created_at' => '2025-01-29 03:06:09', 'updated_at' => '2025-01-29 03:06:09'],
            ['id' => 8, 'strategy_id' => 4, 'name' => 'Add quality teaching staff for undergraduate and postgraduate programs', 'description' => 'Add quality teaching staff for undergraduate and postgraduate programs', 'created_at' => '2025-01-29 03:06:21', 'updated_at' => '2025-01-29 03:06:21'],
            ['id' => 9, 'strategy_id' => 4, 'name' => 'Improve quality of facility and resources for both administration works and programs of SITS', 'description' => 'Improve quality of facility and resources for both administration works and programs of SITS', 'created_at' => '2025-01-29 03:06:35', 'updated_at' => '2025-01-29 03:06:35'],
            ['id' => 10, 'strategy_id' => 5, 'name' => 'Assign at least two young staff members in a leadership positions', 'description' => 'Assign at least two young staff members in a leadership positions', 'created_at' => '2025-01-29 03:06:48', 'updated_at' => '2025-01-30 08:25:11'],
            ['id' => 13, 'strategy_id' => 4, 'name' => 'Finish PMS', 'description' => 'PMS Completion', 'created_at' => '2025-01-30 11:37:42', 'updated_at' => '2025-01-30 11:37:42'],
        ]);
    }
}
