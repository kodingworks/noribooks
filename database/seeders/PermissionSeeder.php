<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // General Group
            [
                'group' => 'general',
                'sub_group' => [
                    [
                        'name' => 'dashboard',
                        'permission' => [
                            [
                                'name' => 'view_general_dashboard',
                                'label' => 'View Dashboard Overview',
                            ]
                        ]
                    ]
                ]
            ],

            // Setting Systems
            [
                'group' => 'setting_systems',
                'sub_group' => [
                    [
                        'name' => 'role_management',
                        'permission' => [
                            [
                                'name' => 'view_settings_role_management',
                                'label' => 'View Role Management',
                            ]
                        ]
                    ],
                    [
                        'name' => 'user_management',
                        'permission' => [
                            [
                                'name' => 'view_settings_user_management',
                                'label' => 'View User Management',
                            ]
                        ]
                    ]
                ]
            ],

            // Accounts
            [
                'group' => 'accounting',
                'sub_group' => [
                    [
                        'name' => 'account',
                        'permission' => [
                            [
                                'name' => 'view_account',
                                'label' => 'View Account',
                            ]
                        ]
                    ],
                    [
                        'name' => 'category',
                        'permission' => [
                            [
                                'name' => 'view_category',
                                'label' => 'View Category',
                            ]
                        ]
                    ],
                ]
            ],
        ];

        // Create permissions 
        try {
            $newPermission = [];
            foreach ($permissions as $group) {
                foreach ($group['sub_group'] as $sub_group) {
                    foreach ($sub_group['permission'] as $permission) {
                        // Create a new one with current id
                        Permission::updateOrCreate([
                            'name' => $permission['name']
                        ], [
                            'name' => $permission["name"],
                            'label' => $permission["label"],
                            'guard_name' => 'web',
                            'group' => $group['group'],
                            'sub_group' => $sub_group['name']
                        ]);

                        array_push($newPermission, $permission['name']);
                    }
                }
            }
            // Get All Permission From database and get the difference then delete it
            $permissionsDb = Permission::get()->pluck('name');
            $diff = array_diff($permissionsDb->toArray(), $newPermission);

            Permission::whereIn('name', array_values($diff))->delete();
        } catch (\Exception $exception) {
            // Do something with the exception
        }
    }
}
