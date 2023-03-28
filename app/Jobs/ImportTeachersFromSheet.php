<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use DB;
use App\Models\ClassLevel;
use App\Models\Student;


class ImportTeachersFromSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $rows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
        //
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rows = $this->rows;
        $schoolInfo = school_info();
        foreach ($rows as $row) {
            $emailExist = DB::table('users')->where('email', $row['email'])->count();
            $phoneExist = DB::table('users')->where('phone', $row['phone'])->count();
            if($emailExist == 0 && $phoneExist == 0) {
                $userId = DB::table('users')->insertGetId([
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'othernames' => $row['othernames'],
                    'email' => $row['email'],
                    'phone' => "0".$row['phone'],
                    'username' => "0".$row['phone'],
                    'school_info_id' => $schoolInfo->id,
                    'gender' => strtolower($row['gender']),
                    'citizenship' => ($row['citizenship']),
                    'state_origin' => ($row['state_of_origin']),
                    'lga_origin' => ($row['local_government']),
                    'role' => "teacher",
                    'password' => bcrypt(strtolower($row['firstname']))
                ]);

                if($userId) {
                    $teacherId = DB::table('teachers')->insertGetId([
                        'user_id' => $userId,
                    ]);
                }
            }
            elseif($emailExist != 0) {
                return null;
            }
            elseif($phoneExist != 0) {
                return null;
            }
        }
    }
}