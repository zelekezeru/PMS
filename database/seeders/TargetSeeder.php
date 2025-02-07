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
            ['id' => 1, 'goal_id' => 1, 'name' => 'Complete 30 Modules for New BA Distance program offered in English Language', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'goal_id' => 2, 'name' => 'At least 5 places: Sodo, Arbaminch, Jimma, Debre Zeit, Nazareth', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'goal_id' => 3, 'name' => '50% of courses offered in accredited hybrid program will have teaching videos uploaded on Moodle', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'goal_id' => 3, 'name' => 'Print 32270 Books for undergraduate program offered in Amharic and Oromifa and 1200 Books for MA in Amharic', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'goal_id' => 3, 'name' => 'Offer 207 courses in MA in Amharic language, BA & Diploma in English language, BA & Diploma in Amharic language MA & MDiv in English Language', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'goal_id' => 3, 'name' => 'Offer leadership training for 1500 local church leaders during graduation weeks by Mission Teams from USA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'goal_id' => 3, 'name' => 'Conduct Graduation for 500 graduates', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'goal_id' => 3, 'name' => 'Intensify and improve spiritual formation of the students in all programs', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'goal_id' => 4, 'name' => 'Increase new enrolled students in the ODEL programs by 800 and Face to Face programs by 200', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'goal_id' => 5, 'name' => 'Increase local revenue 10% from tuition from all programs, 10% from café, 5% from investment, and 5% from highschool', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'goal_id' => 5, 'name' => 'Hawassa café improvement, open area aesthetic improvement', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'goal_id' => 5, 'name' => 'Increase number of student enrollment for highschool', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'goal_id' => 6, 'name' => 'Build A-Substructure and complete first floor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'goal_id' => 7, 'name' => 'Run annual inventory and auditing external auditor 2023 & 2024', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'goal_id' => 8, 'name' => 'Add 5 teaching staff for undergraduate program; have one teaching staff start PhD and 3 start MTh program', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'goal_id' => 9, 'name' => 'Install LMS and enhance Online program facilities', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'goal_id' => 9, 'name' => 'Install security camera with an AI for performance of admin staff and surveillance for library and the compound', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'goal_id' => 9, 'name' => 'Develop recording studio', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'goal_id' => 9, 'name' => 'Install performance Management system for performance monitoring and evaluation', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'goal_id' => 9, 'name' => 'Update and Digitize all students documentation in all programs', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'goal_id' => 9, 'name' => 'Purchase Digital books for Library and pay library system subscription', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'goal_id' => 10, 'name' => 'Evaluate SITS administration, teaching staff, facility, program and students based on ACTEA standard and review the existing curriculums', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'goal_id' => 10, 'name' => 'Improve Teaching, admin staff, and student relationship and spiritual life both in Sodo and Hawassa', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'goal_id' => 10, 'name' => 'Conduct 4 Board meeting (4 meetings per annum), 12 Management meetings, (one\'s in a month), 24 Strategic Plan implementation meeting (fortnightly), 1 General assembly meeting (once in a year), and 2 General staff meeting (2 time per year)', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
