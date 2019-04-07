<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakeUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "admin",
            'full_name' => "Admin Adminowski",
            'email' => "dawidmierzwa95@gmail.com",
            'password' => bcrypt('admin'),
            'permissions' => json_encode(['ADMIN', 'COPYWRITER', 'USER'])
        ]);

        DB::table('users')->insert([
            'name' => "copywriter",
            'full_name' => "Copywriter Adminowski",
            'email' => "copy@copy.com",
            'password' => bcrypt('copy'),
            'permissions' => json_encode(['COPYWRITER', 'USER'])
        ]);

        DB::table('users')->insert([
            'name' => "user",
            'full_name' => "User Adminowski",
            'email' => "user@user.com",
            'password' => bcrypt('user'),
            'permissions' => json_encode(['USER'])
        ]);
    }
}
