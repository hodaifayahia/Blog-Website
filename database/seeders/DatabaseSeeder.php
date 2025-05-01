<?php

namespace Database\Seeders;

use \Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    /** #var \App\Models\User $adminUser */
    public function run(): void
    {
        //  Post::factory(40)->create();
        $adminUser  = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'houdaifa@example.com',
            'password' => bcrypt('password'), // password

        ]);
        $adminRole = Role::create(['name' => 'admin']);

        $adminUser->assignRole($adminRole);
        $adminUser->save();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
