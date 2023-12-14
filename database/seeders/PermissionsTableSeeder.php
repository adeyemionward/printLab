<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define your permissions
        $permissions = [
            'role-create',
            'role-list',
            'role-view',
            'role-edit',
            'role-delete',

            'user-create',
            'user-list',
            'user-edit',
            'user-view',
            'user-delete',

            'job-create',
            'job-list',
            'job-edit',
            'job-view',
            'job-delete',
            'job-update-status',
            'job-track-order',

            'requisition-create',
            'requisition-list',
            'requisition-edit',
            'requisition-view',
            'requisition-delete',

            'supplier-create',
            'supplier-list',
            'supplier-edit',
            'supplier-view',
            'supplier-delete',

            'customer-create',
            'customer-list',
            'customer-edit',
            'customer-view',
            'customer-delete',
            // Add more permissions as needed
        ];

        // Create the permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
