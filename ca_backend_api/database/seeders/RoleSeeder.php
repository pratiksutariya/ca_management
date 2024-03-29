<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'super-admin' , 'guard_name' => 'api']);
        $role = Role::create(['name' => 'ca-admin' , 'guard_name' => 'api']);
        $role = Role::create(['name' => 'user' , 'guard_name' => 'api']);
    }
}
