<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view-home',
            'manage-profile',

            'view-department-users', 'view-users', 'create-users', 'edit-users', 'delete-users', 'approve-users', 'view-waiting-users',

            'view-strategies', 'create-strategies', 'edit-strategies', 'delete-strategies',
            'view-targets', 'create-targets', 'edit-targets', 'delete-targets',
            'view-goals', 'create-goals', 'edit-goals', 'delete-goals',

            'view-years', 'create-years', 'edit-years', 'delete-years',
            'view-quarters', 'create-quarters', 'edit-quarters', 'delete-quarters',
            'view-days', 'create-days', 'edit-days', 'delete-days',

            'view-tasks', 'create-tasks', 'edit-tasks', 'delete-tasks',
            'view-deliverables', 'create-deliverables', 'edit-deliverables', 'delete-deliverables',
            'view-fortnights', 'create-fortnights', 'edit-fortnights', 'delete-fortnights',
            'view-weeks', 'create-weeks', 'edit-weeks', 'delete-weeks',

            'view-feedbacks', 'create-feedbacks', 'edit-feedbacks', 'delete-feedbacks',
            'view-reports', 'create-reports', 'edit-reports', 'delete-reports',
            'view-templates', 'create-templates', 'edit-templates', 'delete-templates',

            'view-kpis', 'create-kpis', 'edit-kpis', 'delete-kpis',
            'create-kpi-target', 'create-kpi-task',

            'view-departments', 'create-departments', 'edit-departments', 'delete-departments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = ['SUPER_ADMIN', 'ADMIN', 'DEPARTMENT_HEAD', 'EMPLOYEE'];

        foreach ($roles as $role) {
            $roleRow = Role::firstOrCreate(['name' => $role]);

            if ($role === 'SUPER_ADMIN') {
                $roleRow->syncPermissions(Permission::all());
            } else if ($role === 'ADMIN') {
                $adminPermissions = array_values(array_diff($permissions, []));
                $roleRow->syncPermissions($adminPermissions);
            } else if ($role === 'DEPARTMENT_HEAD') {
                $headPermissions = array_values(array_diff($permissions, [
                    'create-users', 'edit-users', 'delete-users', 'approve-users', 'view-waiting-users',
                    'create-strategies', 'edit-strategies', 'delete-strategies',
                    'create-targets', 'edit-targets', 'delete-targets',
                    'create-goals', 'edit-goals', 'delete-goals',
                    'create-departments', 'edit-departments', 'delete-departments',
                    'create-years', 'edit-years', 'delete-years',
                    'create-quarters', 'edit-quarters', 'delete-quarters',
                    'create-days', 'edit-days', 'delete-days',
                    'create-fortnights', 'edit-fortnights', 'delete-fortnights',
                    'create-weeks', 'edit-weeks', 'delete-weeks',
                ]));
                $roleRow->syncPermissions($headPermissions);
            } else {

                $employeeRoles = array_values(array_diff($permissions, [
                    'view-users','view-department-users', 'create-users', 'edit-users', 'delete-users', 'approve-users', 'view-waiting-users',
                    'create-strategies', 'edit-strategies', 'delete-strategies',
                    'create-targets', 'edit-targets', 'delete-targets',
                    'create-goals', 'edit-goals', 'delete-goals',
                    'create-years', 'edit-years', 'delete-years',
                    'create-quarters', 'edit-quarters', 'delete-quarters',
                    'create-days', 'edit-days', 'delete-days',
                    'create-deliverables', 'edit-deliverables', 'delete-deliverables',
                    'create-fortnights', 'edit-fortnights', 'delete-fortnights',
                    'create-weeks', 'edit-weeks', 'delete-weeks',
                    'create-reports', 'edit-reports', 'delete-reports',
                    'create-kpis', 'edit-kpis', 'delete-kpis',
                ]));

                $roleRow->syncPermissions($employeeRoles);
            }
        }
    }
}
