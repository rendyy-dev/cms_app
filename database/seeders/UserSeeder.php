<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Editor',
                'username' => 'editor',
                'email' => 'editor@gmail.com',
                'role' => 'editor',
            ],
            [
                'name' => 'Author',
                'username' => 'author',
                'email' => 'author@gmail.com',
                'role' => 'author',
            ],
        ];

        foreach ($users as $data) {
            $role = Role::where('name', $data['role'])->first();

            if (! $role) {
                continue; //safety
            }

            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'role_id' => $role->id,
                    'password' => Hash::make('password'), // Default password
                ]
            );
        }
    }
}
