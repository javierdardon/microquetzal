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
        $users = [
            [
                'name' => 'Developer',
                'lastname' => 'UwU?',
                'email' => 'developer@uwu.com',
                'password' => 'sologrosor',
                'remember_token' => true,
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'lastname' => 'UWU',
                'email' => 'user@gmail.com',
                'password' => 'user',
                'remember_token' => true,
                'role' => 'standard',
            ]
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);

            $created_user->assignRole($user['role']);
        }
    }
}
