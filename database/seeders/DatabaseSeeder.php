<?php

namespace Database\Seeders;

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
        $this->call(SchoolTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TermTableSeeder::class);
        $this->call(SessionYearTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
        $this->call(ClassStageTableSeeder::class);
    }
}
