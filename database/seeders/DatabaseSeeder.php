<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);

        $users = User::all();
        $roles = Role::all();
        foreach ($users as $user) {
            foreach ($roles as $role) {
                if ($user->id === $role->id) {
                    $user->roles()->attach($role->id);
                }
            }
        }
    }
}
