<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleData = [
            [
                'role' => 'developer',
                'info' => 'for developer',
            ],
            [
                'role' => 'administrator',
                'info' => 'for administrator',
            ],
            [
                'role' => 'member',
                'info' => 'for member',
            ],
            [
                'role' => 'individu',
                'info' => 'for individu',
            ],
        ];

        foreach ($roleData as $key => $value) {
            Role::create($value);
        }
    }
}
