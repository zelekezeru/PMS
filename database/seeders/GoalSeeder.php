<?php

namespace Database\Seeders;

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
            ['id' => 1, 'strategy_id' => 1, 'name' => 'Start undergraduate Distance Learning Program', 'description' => 'offered in English', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'strategy_id' => 1, 'name' => 'Start Post Graduate programs at new places', 'description' => 'both Amharic and English media', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'strategy_id' => 1, 'name' => 'Educate 4151 students and out of which graduate 500 students', 'description' => 'train 1500 local leaders', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'strategy_id' => 2, 'name' => 'Increase SITS student body by 1000', 'description' => 'Increase SITS visibility by 50%', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'strategy_id' => 3, 'name' => 'Increase local revenue by 30%- benchmark 2023 local income', 'description' => 'Increase revenue through various sources', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'strategy_id' => 3, 'name' => 'Start new construction at Sodo campus', 'description' => 'Build A-Substructure and complete first floor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'strategy_id' => 3, 'name' => 'Improve financial system through digital technology', 'description' => 'Collect 98% fees through school pay system', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'strategy_id' => 4, 'name' => 'Add quality teaching staff for undergraduate and postgraduate programs', 'description' => 'Add 5 teaching staff for undergraduate program', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'strategy_id' => 4, 'name' => 'Improve quality of facility and resources for both administration works and programs of SITS', 'description' => 'Enhance Online program facilities', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'strategy_id' => 5, 'name' => 'Assign at least two young staff members in a leadership position', 'description' => 'Provide capacity building training', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
