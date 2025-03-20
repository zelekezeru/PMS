<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Zerubbabel Zeleke',
                'phone_number' => '0975210097',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'zelekezeru@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$gisM3bT1R9/1VyHn05D2Kuvfx1EMJ53e7/Dc6NOEN6cWS5/waCQKu',
                'remember_token' => null,
                'created_at' => '2025-02-01 08:18:17',
                'updated_at' => '2025-02-03 08:52:30',
                'department_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Department User',
                'phone_number' => '01111223344',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'department@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$XUUnaM2kj8iqpU9ly76gBueWNom9s0B1G7k8F0mtddF.K4K7s5gFG',
                'remember_token' => null,
                'created_at' => '2025-02-01 18:08:31',
                'updated_at' => '2025-02-02 10:14:08',
                'department_id' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Employee User',
                'phone_number' => '0921212121',
                'is_approved' => 0,
                'is_active' => 0,
                'email' => 'employee@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$QKLpoFl8TgVTqQ3pSbEES.USNOP745ZXr0qMoaASdjuaYeFzMOmZW',
                'remember_token' => null,
                'created_at' => '2025-02-04 05:22:34',
                'updated_at' => '2025-02-04 05:22:34',
                'department_id' => null,
            ],
            [
                'id' => 4,
                'name' => 'Abel Shiferaw',
                'phone_number' => '0906200607',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'abel@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$qCX1z1mIRpxkq170UPhXaeOolCKKqfoTL8x8WF4I05uzXOUjq4NRi',
                'remember_token' => null,
                'created_at' => '2025-02-01 08:15:25',
                'updated_at' => '2025-02-01 08:15:25',
                'department_id' => 4,
            ],
            [
                'id' => 5,
                'name' => 'Eyasu Mesele',
                'phone_number' => '0976897892',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'meseleeyasu42@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$ewGB.h5ouWgcOHDOmY0zc.aH/2dwNFRf8anNE6JMjtcK.XjE8LI2y',
                'remember_token' => null,
                'created_at' => '2025-02-01 08:22:44',
                'updated_at' => '2025-02-01 18:29:48',
                'department_id' => null,
            ],
            [
                'id' => 6,
                'name' => 'Dr Endale Sebsebe',
                'phone_number' => '0911914027',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'esebsebe@yahoo.com',
                'email_verified_at' => null,
                'password' => '$2y$12$lc6aCU27B/K6D16BGwMLGO2UmxJrQ2.utTpDZISuIqEIhLRjQoF0e',
                'remember_token' => null,
                'created_at' => '2025-02-01 09:28:13',
                'updated_at' => '2025-02-01 09:29:24',
                'department_id' => null,
            ],
            [
                'id' => 7,
                'name' => 'Misganu Petros',
                'phone_number' => '0937216471',
                'is_approved' => 1,
                'is_active' => 1,
                'email' => 'pmesge@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$zS9f2TDpuTyBnTm3smCrZekKAwmPGqCp.T8qjbbNcovKG/Z5bxQhK',
                'remember_token' => null,
                'created_at' => '2025-02-01 09:40:08',
                'updated_at' => '2025-02-01 09:41:46',
                'department_id' => null,
            ],
        ]);

    }
}
