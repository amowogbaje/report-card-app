<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('school_infos')->insert([
            'name' => "Ambassador's Collge",
            'codename' => 'AMB',
            'address' => '.....',
            'type' => 'secondary',
        ]);
    }
}
