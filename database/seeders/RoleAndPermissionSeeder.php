<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = [
            'Admin',
            'Trainer',
            'Trainee',
        ];

        // Check if each role exists before creating it
        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }

        // Define permissions
        $permissions = [
            'can_create_trainer',
            'can_edit_trainer',
            'can_delete_trainer',
            'can_view_trainer',
            'can_update_trainer',
            'can_view_class_schedules',
            'can_assign_trainer',
            'can_view_assigned_class_schedules',
            'can_edit_profile',
            'can_book_available_classes',
        ];

        // Check if each permission exists before creating it
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Assign permissions to roles
        $admin = Role::findByName('Admin');
        $admin->givePermissionTo([
            'can_create_trainer', 
            'can_assign_trainer', 
            'can_edit_trainer', 
            'can_delete_trainer', 
            'can_view_trainer', 
            'can_update_trainer'
        ]); // Admin has all permissions

        $trainer = Role::findByName('Trainer');
        $trainer->givePermissionTo([
            'can_view_assigned_class_schedules'
        ]); // Trainer can view assigned class schedules

        $trainee = Role::findByName('Trainee');
        $trainee->givePermissionTo([
            'can_book_available_classes', 
            'can_edit_profile'
        ]); // Trainee can book classes and edit profile
    }
}
