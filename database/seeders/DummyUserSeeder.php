<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'developer',
                'email' => 'developer@gmail.com',
                'role' => 'developer',
                'password' => bcrypt('123123')
            ],
            [
                'name' => 'administrator',
                'email' => 'administrator@gmail.com',
                'role' => 'administrator',
                'password' => bcrypt('123123')
            ],
            [
                'name' => 'member',
                'email' => 'member@gmail.com',
                'role' => 'member',
                'password' => bcrypt('123123')
            ],
            [
                'name' => 'individu',
                'email' => 'individu@gmail.com',
                'role' => 'individu',
                'password' => bcrypt('123123')
            ],
        ];

        foreach ($userData as $key => $value) {
            User::create($value);
        }
    }
}
