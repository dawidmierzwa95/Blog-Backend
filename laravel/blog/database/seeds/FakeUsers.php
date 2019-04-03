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
            'email' => "admin@admin.com",
            'password' => bcrypt('admin'),
            'permissions' => json_encode(['ADMIN', 'COPYWRITER', 'USER'])
        ]);
    }
}
