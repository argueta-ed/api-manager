<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user with the 'administrador' role
        $admin = User::create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);
        $admin->assignRole('administrador');

        // Create a default user with the 'revisor' role
        $revisor = User::create([
            'firstname' => 'revisor',
            'lastname' => 'revisor',
            'email' => 'revisor@revisor.com',
            'password' => Hash::make('revisor')
        ]);
        $revisor->assignRole('revisor');

        // Create 100 random users and assign them random roles
        User::factory(100)->create()->each(function ($user) {
            // Assign random roles to the created users
            $roles = ['administrador', 'revisor'];
            $user->assignRole($roles[array_rand($roles)]);
        });

    }
}
