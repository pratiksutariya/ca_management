<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\{User};


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            array(
                "data" => [
                    "name" => "Super Admin",
                    "email" => "super_admin@gmail.com",
                    "password" => bcrypt('Animal12!@'),
                    "visible_password" => "Animal12!@",
                ],
                "role" => "super-admin"
            ),
            array(
                "data" => [
                    "name" => "admin",
                    "email" => "admin@gmail.com",
                    "password" => bcrypt('Animal12!@'),
                    "visible_password" => "Animal12!@",
                ],
                "role" => "admin"
            ),
            array(
                "data" => [
                    "name" => "user",
                    "email" => "user@gmail.com",
                    "password" => bcrypt('Animal12!@'),
                    "visible_password" => "Animal12!@",
                ],
                "role" => "user"
            )
        );

        foreach($users as $user) {
            $user_create = User::create($user["data"]);
            $role = Role::where('name' , $user['role'])->first();
            $user_create->assignRole($role);
        } 
    }
}
