<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use DB;
use App\Models\Subject;
use App\Models\Student;

class ActiveResultForStudent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $students;
    public function __construct($students)
    {
        //
        $this->students = $students;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        
        $students = $this->students;
        
        foreach ($students as $student) {
            $subjects = Subject::where('class_stage_id', $student->class_stage_id)
                                    ->where('category', null)->get();
                foreach($subjects as $subject) {
                    $subjectAlreadyRegistered = DB::table('results')->where([
                        'session_id' => $current_session_id,
                        'term_id' => $current_term_id,
                        'subject_id' => $subject->id,
                        'class_id' => $student->class_id,
                        'student_id' => $student->id,
                    ])->count();
                    
                    if($subjectAlreadyRegistered !=0) {
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
        }
    }
}