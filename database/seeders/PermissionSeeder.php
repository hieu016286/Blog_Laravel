<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'Index Post',
            ],
            [
                'name' => 'Create Post',
            ],
            [
                'name' => 'Edit Post',
            ],
            [
                'name' => 'Delete Post',
            ]
        ]);
    }
}
