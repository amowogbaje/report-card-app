<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('class_levels')->insert([

            'name' => 'Junior Secondary School 1',
            'shortname' => 'JSS1',
            'code' =>"001",
            'type' => 'secondary',
            'class_stage_id'=> 6,
            // 'school_fee' => '15000',
        ]);

        \DB::table('class_levels')->insert([

            'name' => 'Junior Secondary School 2',
            'shortname' => 'JSS2',
            'code' =>"002",
            'type' => 'secondary',
            'class_stage_id'=> 6,
            // 'school_fee' => '18000',
        ]);

        \DB::table('class_levels')->insert([

            'name' => 'Junior Secondary School 3',
            'shortname' => 'JSS3',
            'code' =>"003",
            'type' => 'secondary',
            'class_stage_id'=> 6,
            // 'school_fee' => '21000',
        ]);

        \DB::table('class_levels')->insert([

            'name' => 'Senior Secondary School 1',
            'shortname' => 'SSS1',
            'code' =>"004",
            'type' => 'secondary',
            'class_stage_id'=> 7,
            // 'school_fee' => '15000',
        ]);

        \DB::table('class_levels')->insert([

            'name' => 'Senior Secondary School 2',
            'shortname' => 'SSS2',
            'code' =>"005",
            'type' => 'secondary',
            'class_stage_id'=> 7,
            // 'school_fee' => '18000',
        ]);

        \DB::table('class_levels')->insert([

            'name' => 'Junior Secondary School 3',
            'shortname' => 'SSS3',
            'code' =>"006",
            'type' => 'secondary',
            'class_stage_id'=> 7,
            // 'school_fee' => '21000',
        ]);
        
    }
}
