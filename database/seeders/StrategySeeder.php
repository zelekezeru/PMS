<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('strategies')->insert([
            ['name' => '1. Make SITS programs accessible to potential  and existing  students at any time and place!','pillar_name' => 'Pillars 1: Program and Content Delivery Mode', 'description' => 'Description for Strategy 1'],
            ['name' => '2. Realize exponential growth of students body at SITS in all programs.','pillar_name' => 'Pillar 2: Students and Students’ Enrollment', 'description' => 'Description for Strategy 2'],
            ['name' => '3.Create viable and regular income source for SITS through rendering services to the general public!','pillar_name' => 'Pillar 3: Finance',  'description' => 'Description for Strategy 3'],
            ['name' => '4. Acquire and retain adequate qualified personnel and up-to-date technology and key facilities.','pillar_name' => 'Pillar 4: Organizational Capacity- human resources, technology and facilit',  'description' => 'Description for Strategy 4'],
            ['name' => '5. Develop an effective leadership development process in all SITS position','pillar_name' => 'Pillar 5: Governance, Leadership Development and Partnership',  'description' => 'Description for Strategy 5'],
            ]);
    }
}
