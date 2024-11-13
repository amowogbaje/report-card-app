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
use App\Models\SubjectTerm;

use Auth;
use DB;

class BootstrapStudentForTerm implements ShouldQueue
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
        $newAssessment->class_id = $student->class_id;
        $newAssessment->school_info_id = Auth::user()->school_info_id;
        $percentage = "Not Ready"; $markObtained = "Not Ready"; $markObtainable = "Not Ready";
        $newAssessment->academic_assessments = json_encode(compact('percentage', 'markObtained', 'markObtainable'));
        $newAssessment->save();
        if($student->class_stage_id == 6) {
            $subjects = SubjectTerm::where('class_stage_id', $student->class_stage_id)
                                ->where('session_id', active_session()->id)
                                ->where('term_id', active_term()->id)->get();
            foreach($subjects as $subject) {
                        DB::table('results')->insert([
                            'session_id' => $current_session_id,
                            'term_id' => $current_term_id,
                            'subject_id' => $subject->subject_id,
                            'class_id' => $student->class_id,
                            'class_code' => $student->class_code,
                            'student_id' => $student->id,
                            'totalca' => 0,
                            'total_score' => 0,
                        ]);
                    
                        
            }
        }
        
        

        DB::table('payment_codes')->insert([
            'session_id' => active_session()->id,
            'term_id' => active_term()->id,
            'student_id' => $student->id,
            'payment_verification_code' => FLOOR(RAND() * 401) + 100
        ]);
    }
}
