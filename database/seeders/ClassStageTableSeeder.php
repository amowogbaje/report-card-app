<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ClassStageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('class_stages')->insert([
            'name' => 'Toddler',
            'shortname' => 'toddler',
            'groupname' => 'toddler'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Kindergaten',
            'shortname' => 'kg',
            'groupname' => 'kg'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Nursery',
            'shortname' => 'nursery',
            'groupname' => 'nursery'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Lower Basic',
            'shortname' => 'lower_basic',
            'groupname' => 'primary'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Upper Basic',
            'shortname' => 'upper_basic',
            'groupname' => 'primary'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Junior Secondary',
            'shortname' => 'junior',
            'groupname' => 'secondary'
        ]);
        \DB::table('class_stages')->insert([
            'name' => 'Senior Secondary',
            'shortname' => 'senior',
            'groupname' => 'secondary'
        ]);
        

    }
}
