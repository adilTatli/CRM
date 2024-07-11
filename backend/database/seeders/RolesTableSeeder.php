<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'Accountant',
                'slug'        => 'accountant',
                'description' => 'Accountant Role',
                'level'       => 3,
            ],
            [
                'name'        => 'Manager',
                'slug'        => 'manager',
                'description' => 'Manager Role',
                'level'       => 4,
            ],
            [
                'name'        => 'Dispatch',
                'slug'        => 'dispatch',
                'description' => 'Dispatch Role',
                'level'       => 2,
            ],
            [
                'name'        => 'Technician',
                'slug'        => 'technician',
                'description' => 'Technician Role',
                'level'       => 2,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
