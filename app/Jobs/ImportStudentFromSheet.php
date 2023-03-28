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
use App\Models\ClassAssessment;
use App\Models\Student;
use App\Jobs\BootstrapStudents;

use Auth;

class ImportStudentFromSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $class_id, $rows;
    public function __construct($class_id, $rows)
    {
        //
        $this->class_id = $class_id;
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $rows = $this->rows;
        $schoolInfo = school_info();
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        foreach ($rows as $row) {
            
            $emailExist = DB::table('users')->where('email', $row['email'])->count();
            $phoneExist = DB::table('users')->where('phone', $row['phone'])->count();
            if($emailExist == 0 && $phoneExist == 0) {
                $userId = DB::table('users')->insertGetId([
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'othernames' => $row['othernames'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    // 'dob' => $row['date_of_birth'],
                    'username' => "not yet assigned",
                    'school_info_id' => $schoolInfo->id,
                    'gender' => strtolower($row['gender']),
                    'citizenship' => ($row['citizenship']),
                    'state_origin' => ($row['state_of_origin']),
                    'lga_origin' => ($row['local_government']),
                    'address' => $row['guardian_address'],
                    'role' => "student",
                    'password' => bcrypt(strtolower($row['firstname']))
                ]);
    
                if($userId) {
                    $studentClassCode = Classlevel::where('id', $this->class_id)->first()->code;
                    $firstStudentCheck = Student::where('class_code', $studentClassCode)->count();
                    if($firstStudentCheck == 0) {
                        $StudentMatricNo = "001";
                    }
                    else {
                        $previousStudentMatricNo = Student::where('class_code', $studentClassCode)
                                                    ->latest('id')->first()->class_matric_no;
                        $currentStudentMatricNo = (int) $previousStudentMatricNo + 1;
                        $StudentMatricNo = sprintf("%03d", $currentStudentMatricNo);
                    }
                    // $category = null;
                    // if(trim($row[13]) != "") {$category = $row[13];}

    
                    $studentId = DB::table('students')->insertGetId([
                        'user_id' => $userId,
                        'guardian_phone' => $row['phone'],
                        // 'email' => $row[3],
                        'class_code' => Classlevel::where('id', $this->class_id)->first()->code,
                        'class_matric_no' => $StudentMatricNo,
                        // 'school_info_id' => $schoolInfo->id,
                        'class_id' => $this->class_id,
                        'guardian_name' => $row['guardian_name'],
                        'guardian_address' => $row['guardian_address'],
                        'class_stage_id' => Classlevel::where('id', $this->class_id)->first()->class_stage_id,
                        // 'category' => $category,
                    ]);

                    $student = Student::where('id', $studentId)->first();
    
                    if($student) {
                        BootstrapStudents::dispatch($student);
                    }
                }
            }
            elseif($emailExist != 0) {
                return null;
            }
            elseif($phoneExist != 0) {
                return null;
            }
            
            
        }

        ClassAssessment::insert([
            'highest_score' => 0,
            'lowest_score' => 0,
            'average_score' => 0,
            'session_id' => $current_session_id,
            'term_id' => $current_term_id,
            'class_id' => $this->class_id
        ]);
    }
}
