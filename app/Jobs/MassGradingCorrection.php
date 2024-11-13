<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\ClassStudent;
use App\Models\ClassLevel;
use App\Models\Assessment;
use App\Models\Result;
use App\Models\Student;
use App\Models\User;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;

use Auth;
use DB;

class MassGradingCorrection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $class_code;
    protected $subject_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($class_code, $subject_id)
    {
        $this->class_code = $class_code;
        $this->subject_id = $subject_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $result = Result::where('session_id', active_session()->id)
                        ->where('term_id', active_term()->id)
                        ->where('class_code', $this->class_code)
                        //->where('subject_id', $this->subject_id)
                        ->get();
            foreach ($result as $student) {
                 if($student->classlevel->class_stage_id == 7) {
                     DB::table('results')->where('session_id', active_session()->id)
                             ->where('term_id', active_term()->id)
                             ->where('student_id', $student->student_id)
                             ->where('subject_id', $student->subject_id)
                             ->update(["grade"=>$this->getGradeForSenior($student->cumulative_percentage)]);
                 }
                if($student->classlevel->class_stage_id < 7) {
                    DB::table('results')->where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_id', $student->subject_id)
                            ->update(["grade"=>$this->getGradeForJunior($student->cumulative_percentage)]);
                }
                
            }
        
    }
    
    public function getGradeForSenior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F9";}
        if($scores >= 40 && $scores <= 44) {$grade = "E8";}
        if($scores >= 45 && $scores <= 49) {$grade = "D7";}
        if($scores >= 50 && $scores <= 54) {$grade = "C6";}
        if($scores >= 55 && $scores <= 59) {$grade = "C5";}
        if($scores >= 60 && $scores <= 64) {$grade = "C4";}
        if($scores >= 65 && $scores <= 69) {$grade = "B3";}
        if($scores >= 70 && $scores <= 74) {$grade = "B2";}
        if($scores >= 75 && $scores <= 100) {$grade = "A1";}

        return $grade;
    }
    
    public function getGradeForJunior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F";}
        if($scores >= 40 && $scores <= 49) {$grade = "P";}
        // if($scores >= 45 && $scores <= 49) {$grade = "D";}
        if($scores >= 50 && $scores <= 59) {$grade = "C";}
        if($scores >= 60 && $scores <= 69) {$grade = "B";}
        if($scores >= 70 && $scores <= 100) {$grade = "A";}

        return $grade;
    }
}
