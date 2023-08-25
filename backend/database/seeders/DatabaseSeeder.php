<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com'
        ]);

        $user2 = User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com'
        ]);
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'moderator']);
        
        $user1->assignRole($role1);
        $user2->assignRole($role2);
    }
}
