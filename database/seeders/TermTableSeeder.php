<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        \DB::table('terms')->insert([

            'name' => 'First',
            'number' => '1',
            'active' => 1,
        ]);

        \DB::table('terms')->insert([

            'name' => 'Second',
            'number' => '2',
        ]);

        \DB::table('terms')->insert([

            'name' => 'Third',
            'number' => '3',
        ]);
    }
}
