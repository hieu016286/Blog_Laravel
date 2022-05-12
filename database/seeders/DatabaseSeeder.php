<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
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

        $guest = Role::where('name', '=', 'guest')->first();
        $guest->permissions()->attach(Permission::whereNotIn('name', ['Index Posts'])->pluck('id')->toArray());
    }
}
