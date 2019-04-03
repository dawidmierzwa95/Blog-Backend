<?php

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
        $this->call(FakeUsers::class);
        $this->call(FakeTags::class);
        $this->call(FakeArticles::class);
        $this->call(FakeComments::class);
    }
}
