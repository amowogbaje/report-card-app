<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([

            'firstname' => 'Gideon',
            'lastname' => 'Amowogbaje',
            'othernames' => 'Ifedayo',
            'username' => 'amowogbajegideon@gmail.com',
            'role' => 'admin',
            'phone' => '08174007780',
            'school_info_id' => 1,
            'gender' => 'male',
            'password' => bcrypt('gideon'),
            'email' => 'amowogbajegideon@gmail.com',
        ]);

        \DB::table('users')->insert([

            'firstname' => 'Not Yet',
            'lastname' => 'Assigned',
            'othernames' => 'Amowogbaje',
            'role' => 'teacher',
            'phone' => 'xxxxxxxxx',
            'username' => 'xxxxxxx',
            'gender' => 'invalid',
            'school_info_id' => -1,
            'password' => bcrypt('dummy'),
            'email' => 'dummyteacher@gmail.com',
        ]);

    }
}
