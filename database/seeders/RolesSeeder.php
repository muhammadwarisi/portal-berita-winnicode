<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator',
            ],
            [
                'name' => 'Author',
                'description' => 'Penulis Lepas',
            ],
            [
                'name' => 'Reviewer',
                'description' => 'Peninjau Artikel',
            ],
        ];

        foreach ($roles as $role) {
            Roles::create($role);
        }
    }
}
