<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('targets')->insert([
            ['id' => 1, 'name' => 'Complete 30 Modules for New BA Distance program offered in English Language', 'budget' => '2280000', 'value' => 5.00, 'unit' => 'NUM', 'goal_id' => 2, 'created_at' => '2025-01-29 03:44:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 2, 'name' => 'At least 5 places: Sodo, Arbaminich, Jimma, Debre Zeit, Nazereth', 'budget' => '25,000', 'value' => NULL, 'unit' => NULL, 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 3, 'name' => '50% of courses offered in accredited hybrid program will have teaching videos uploaded on Moodle', 'budget' => '25,000', 'value' => 50.00, 'unit' => 'PERCENT', 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 4, 'name' => 'Print 32270 Books for undergraduate program offered in Amharic and Oromifa and 1200 Books for MA in Amharic', 'budget' => '25,000', 'value' => 32270, 'unit' => 'NUM', 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 5, 'name' => 'Offer 207 courses in MA in Amharic language, BA & Diploma in English language, BA & Diploma in Amharic language, MA & MDiv in English Language', 'budget' => '25,000', 'value' => 207, 'unit' => 'NUM', 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 6, 'name' => 'Offer leadership training for 1500 local church leaders during graduation weeks by Mission Teams from USA', 'budget' => '25,000', 'value' => 1500, 'unit' => 'NUM', 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 7, 'name' => 'Conduct Graduation for 500 graduates', 'budget' => '25,000', 'value' => 500, 'unit' => 'NUM', 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
            ['id' => 8, 'name' => 'Intensify and improve spiritual formation of the students in all programs', 'budget' => '25,000', 'value' => NULL, 'unit' => NULL, 'goal_id' => 2, 'created_at' => '2025-01-30 08:41:42', 'updated_at' => '2025-01-30 08:41:42'],
        ]);
    }
}
