<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $permissionItems = [
            [
                'name'        => 'Can View Dispatch',
                'slug'        => 'view.dispatch',
                'description' => 'Can view dispatch panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Manager',
                'slug'        => 'view.manager',
                'description' => 'Can view manager panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Parts',
                'slug'        => 'view.parts',
                'description' => 'Can view parts panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Billing',
                'slug'        => 'view.billing',
                'description' => 'Can view billing panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Completed',
                'slug'        => 'view.completed',
                'description' => 'Can view completed panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Additional',
                'slug'        => 'view.additional',
                'description' => 'Can view additional panel',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Enter',
                'slug'        => 'view.enter',
                'description' => 'Can view enter panel',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($permissionItems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
