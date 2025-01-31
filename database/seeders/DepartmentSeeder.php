<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['id' => 1, 'department_name' => 'President', 'description' => 'President Department', 'created_at' => '2025-01-31 07:24:14', 'updated_at' => '2025-01-31 07:27:43'],
            ['id' => 2, 'department_name' => 'ODEL', 'description' => 'Online and Distance Learning Department', 'created_at' => '2025-01-31 07:24:39', 'updated_at' => '2025-01-31 07:24:39'],
            ['id' => 3, 'department_name' => 'Admin', 'description' => 'Administration Department', 'created_at' => '2025-01-31 07:25:00', 'updated_at' => '2025-01-31 07:28:10'],
            ['id' => 4, 'department_name' => 'IT', 'description' => 'IT Department', 'created_at' => '2025-01-31 07:25:12', 'updated_at' => '2025-01-31 07:25:12'],
            ['id' => 5, 'department_name' => 'Registrar', 'description' => 'Registrar Department', 'created_at' => '2025-01-31 07:26:05', 'updated_at' => '2025-01-31 07:26:05'],
            ['id' => 6, 'department_name' => 'Library', 'description' => 'Library Department', 'created_at' => '2025-01-31 07:26:48', 'updated_at' => '2025-01-31 07:26:48'],
            ['id' => 7, 'department_name' => 'Academic Dean', 'description' => 'Academic and Post Graduate Dean', 'created_at' => '2025-01-31 07:27:26', 'updated_at' => '2025-01-31 07:27:26'],
            ['id' => 8, 'department_name' => 'Finance', 'description' => 'Finance and Accounting Department', 'created_at' => '2025-01-31 07:28:36', 'updated_at' => '2025-01-31 07:28:36'],
        ]);
    }
}
