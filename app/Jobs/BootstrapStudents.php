<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\ClassStudent;
use App\Models\Assessment;
use App\Models\Result;
use App\Models\Student;
use App\Models\User;
use App\Models\Subject;

use Auth;
use DB;

class BootstrapStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $student = $this->student;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $schoolInfo = school_info();

        $classStudent = new ClassStudent;
        $classStudent->student_id = $student->id;
        $classStudent->class_id = $student->class_id;
        $classStudent->session_id = $current_session_id;
        $classStudent->term_id = $current_term_id;
        $classStudent->save();

        $newAssessment = new Assessment;
        $newAssessment->session_id = $current_session_id;
        $newAssessment->term_id = $current_term_id;
        $newAssessment->student_id = $student->id;
        $newAssessment->school_info_id = Auth::user()->school_info_id;
        $newAssessment->save();
        if($student->class_stage_id == 6) {
            $subjects = Subject::where('class_stage_id', $student->class_stage_id)->get();
            foreach($subjects as $subject) {
                DB::table('results')->insert([
                    'session_id' => $current_session_id,
                    'term_id' => $current_term_id,
                    'subject_id' => $subject->id,
                    'class_id' => $student->class_id,
                    'student_id' => $student->id,
                    'totalca' => 0,
                    'total_score' => 0,
                ]);
            }
        }
        
        // $classCode = Classlevel::where('id', $student->class_id)->first()->code;
        
        // $studentIDInThreeDigits = sprintf("%03d", $student->id);
        // $classIDInThreeDigits = sprintf("%03d", $student->class_id);

        $user = User::find($student->user_id);
        $user->username = $schoolInfo->codename."/".$student->class_code."/".$student->class_matric_no;
        $user->save();
    }
}
