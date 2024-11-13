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
use App\Models\ClassLevel;
use App\Models\ClassAssessment;
use App\Jobs\BootstrapStudentForTerm;

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
            BootstrapStudentForTerm::dispatch($student);
           
        }
        $classlevels = ClassLevel::all();
        foreach ($classlevels as $classlevel) {
            ClassAssessment::insert([
                'highest_score' => 0,
                'lowest_score' => 0,
                'average_score' => 0,
                'session_id' => $current_session_id,
                'term_id' => $current_term_id,
                'class_id' => $classlevel->id
            ]);
        }
    }
}