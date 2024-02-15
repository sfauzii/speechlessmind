<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Kevin',
        //     'email' => 'kevin@gmail.com',
        //     'password' => bcrypt('password')
        // ]);

        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $user2 = User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ]);

        $role = Role::create(['name' => 'superadmin']);
        $user1->assignRole($role);

        $role = Role::create(['name' => 'user']);
        $user2->assignRole($role);


    }
}
