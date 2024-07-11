<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Roles.
         */
        $roleAdmin = config('roles.models.role')::where('name', '=', 'Admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }

        $roleManager = config('roles.models.role')::where('name', '=', 'Manager')->first();
        $permissionManager = config('roles.models.permission')::where('slug', '=', 'view.manager')->first();
        $permissionEnter = config('roles.models.permission')::where('slug', '=', 'view.enter')->first();
        $permissionParts = config('roles.models.permission')::where('slug', '=', 'view.parts')->first();
        $permissionDispatch = config('roles.models.permission')::where('slug', '=', 'view.dispatch')->first();
        $permissionAccountant = config('roles.models.permission')::where('slug', '=', 'view.billing')->first();
        $roleManager->attachPermission($permissionManager);
        $roleManager->attachPermission($permissionEnter);
        $roleManager->attachPermission($permissionParts);
        $roleManager->attachPermission($permissionAccountant);
        $roleManager->attachPermission($permissionDispatch);

        $roleAccountant = config('roles.models.role')::where('name', '=', 'Accountant')->first();
        $roleAccountant->attachPermission($permissionAccountant);
        $roleAccountant->attachPermission($permissionEnter);
        $roleAccountant->attachPermission($permissionParts);
        $roleAccountant->attachPermission($permissionDispatch);

        $roleDispatch = config('roles.models.role')::where('name', '=', 'Dispatch')->first();
        $roleDispatch->attachPermission($permissionDispatch);
        $roleDispatch->attachPermission($permissionEnter);

        $roleTechnician = config('roles.models.role')::where('name', '=', 'Technician')->first();
        $roleTechnician->attachPermission($permissionParts);
        $roleTechnician->attachPermission($permissionEnter);
    }
}
