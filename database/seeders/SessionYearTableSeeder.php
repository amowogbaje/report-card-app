<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SessionYearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('session_years')->insert([

            'name' => '2022/2023',
            'active' => 1,
        ]);
        //
    }
}
