<?php

namespace Database\Seeders;

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
            ['department_name' => 'President', 'department_head' => null, 'description' => 'President Department', 'created_at' => '2025-01-31 04:24:14', 'updated_at' => '2025-01-31 04:27:43'],
            ['department_name' => 'Program Director', 'department_head' => null, 'description' => 'Program director', 'created_at' => '2025-01-31 04:24:39', 'updated_at' => '2025-01-31 08:46:18'],
            ['department_name' => 'Operational Manager', 'department_head' => null, 'description' => 'Operational Manager Department', 'created_at' => '2025-01-31 04:25:00', 'updated_at' => '2025-01-31 08:47:28'],
            ['department_name' => 'Quality Assurance', 'department_head' => null, 'description' => 'Quality Assurance Department', 'created_at' => '2025-01-31 04:25:12', 'updated_at' => '2025-01-31 08:46:58'],
            ['department_name' => 'Highschool', 'department_head' => null, 'description' => 'Highschool Director Department', 'created_at' => '2025-01-31 04:26:05', 'updated_at' => '2025-01-31 08:49:05'],
            ['department_name' => 'IT', 'department_head' => null, 'description' => 'IT Department', 'created_at' => '2025-01-31 04:26:48', 'updated_at' => '2025-01-31 08:49:46'],
            ['department_name' => 'Finance', 'department_head' => null, 'description' => 'Finance and Accounting Department', 'created_at' => '2025-01-31 04:27:26', 'updated_at' => '2025-01-31 08:53:14'],
            ['department_name' => 'ODEL', 'department_head' => null, 'description' => 'Online, Distance and E-learning Department', 'created_at' => '2025-01-31 04:28:36', 'updated_at' => '2025-01-31 08:53:08'],
            ['department_name' => 'Library', 'department_head' => null, 'description' => 'Library Department', 'created_at' => '2025-01-31 08:53:46', 'updated_at' => '2025-01-31 08:53:46'],
            ['department_name' => 'Registrar', 'department_head' => null, 'description' => 'Registrar Department', 'created_at' => '2025-01-31 08:54:14', 'updated_at' => '2025-01-31 08:54:14'],
            ['department_name' => 'Admin Department', 'department_head' => null, 'description' => 'Administration Department', 'created_at' => '2025-01-31 08:54:58', 'updated_at' => '2025-01-31 08:54:58'],
            ['department_name' => 'Satellite Campus', 'department_head' => null, 'description' => 'Satellite campus Coordinator', 'created_at' => '2025-01-31 08:56:05', 'updated_at' => '2025-01-31 08:56:05'],
        ]);
    }
}
