<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Add this line
use Spatie\Permission\Models\Permission; // Add this line

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if the role already exists before creating it
        if (!Role::where('name', 'SUPER_ADMIN')->exists()) {
            Role::create(['name' => 'SUPER_ADMIN']);
        }

        $this->call([
            DepartmentSeeder::class,
            GoalSeeder::class,
            YearSeeder::class,
            QuarterSeeder::class,
            StrategySeeder::class,
            TargetSeeder::class,
            FortnightSeeder::class,
            PermissionSeeder::class,
            ModelHasRolesSeeder::class,
            UserSeeder::class,
        ]);
    }
}
