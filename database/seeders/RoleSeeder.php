<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'super admin',
                'is_default' => true,
                'permissions' => ['view_general_dashboard', 'view_settings_role_management']
            ],
            [
                'name' => 'user',
                'is_default' => true,
                'permissions' => []
            ]
        ];

        // Create role and assign permission to role
        foreach ($data as $key => $value) {
            try {
                $role = Role::updateOrCreate([
                    'id' => $key + 1
                ], [
                    'id' => $key + 1,
                    'name' => $value["name"],
                    'is_default' => $value["is_default"],
                ]);

                $role->givePermissionTo($value['permissions']);
            } catch (\Exception $exception) {
                $this->command->info($exception->getMessage());
                // Do something when the exception 
            }
        }
    }
}
