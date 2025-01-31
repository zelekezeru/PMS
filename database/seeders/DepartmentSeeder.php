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
            ['id' => 1, 'department_name' => 'President', 'department_head' => NULL, 'description' => 'President Department', 'created_at' => '2025-01-31 04:24:14', 'updated_at' => '2025-01-31 04:27:43'],
            ['id' => 2, 'department_name' => 'Program Director', 'department_head' => NULL, 'description' => 'Program director', 'created_at' => '2025-01-31 04:24:39', 'updated_at' => '2025-01-31 08:46:18'],
            ['id' => 3, 'department_name' => 'Operational Manager', 'department_head' => NULL, 'description' => 'Operational Manager Department', 'created_at' => '2025-01-31 04:25:00', 'updated_at' => '2025-01-31 08:47:28'],
            ['id' => 4, 'department_name' => 'Quality Assurance', 'department_head' => NULL, 'description' => 'Quality Assurance Department', 'created_at' => '2025-01-31 04:25:12', 'updated_at' => '2025-01-31 08:46:58'],
            ['id' => 5, 'department_name' => 'Highschool', 'department_head' => NULL, 'description' => 'Highschool Director Department', 'created_at' => '2025-01-31 04:26:05', 'updated_at' => '2025-01-31 08:49:05'],
            ['id' => 6, 'department_name' => 'IT', 'department_head' => NULL, 'description' => 'IT Department', 'created_at' => '2025-01-31 04:26:48', 'updated_at' => '2025-01-31 08:49:46'],
            ['id' => 7, 'department_name' => 'Finance', 'department_head' => NULL, 'description' => 'Finance and Accounting Department', 'created_at' => '2025-01-31 04:27:26', 'updated_at' => '2025-01-31 08:53:14'],
            ['id' => 8, 'department_name' => 'ODEL', 'department_head' => NULL, 'description' => 'Online, Distance and E-learning Department', 'created_at' => '2025-01-31 04:28:36', 'updated_at' => '2025-01-31 08:53:08'],
            ['id' => 9, 'department_name' => 'Library', 'department_head' => NULL, 'description' => 'Library Department', 'created_at' => '2025-01-31 08:53:46', 'updated_at' => '2025-01-31 08:53:46'],
            ['id' => 10, 'department_name' => 'Registrar', 'department_head' => NULL, 'description' => 'Registrar Department', 'created_at' => '2025-01-31 08:54:14', 'updated_at' => '2025-01-31 08:54:14'],
            ['id' => 11, 'department_name' => 'Admin Department', 'department_head' => NULL, 'description' => 'Administration Department', 'created_at' => '2025-01-31 08:54:58', 'updated_at' => '2025-01-31 08:54:58'],
            ['id' => 12, 'department_name' => 'Satellite Campus', 'department_head' => NULL, 'description' => 'Satellite campus Coordinator', 'created_at' => '2025-01-31 08:56:05', 'updated_at' => '2025-01-31 08:56:05'],
        ]);
    }
}
