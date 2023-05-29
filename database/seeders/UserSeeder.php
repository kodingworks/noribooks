<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = User::updateOrCreate(
        [
            'email' => 'superadmin@gmail.com'
        ],
        [
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('rahasia123')
        ]);
        $super_admin->assignRole('super admin');
        
        for ($i=0; $i < 10 ; $i++) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('rahasia123'),
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('user');
        }
    }
}
