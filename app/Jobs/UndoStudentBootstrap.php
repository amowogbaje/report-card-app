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
use App\Models\PaymentCode;

class UndoStudentBootstrap implements ShouldQueue
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

        // Delete records in reverse order of creation in BootstrapStudents

        // Delete payment code
        PaymentCode::where('student_id', $student->id)->where('session_id', active_session()->id)->where('term_id', active_term()->id)->delete();

        // Delete results
        Result::where('student_id', $student->id)->where('session_id', active_session()->id)->where('term_id', active_term()->id)->delete();

        // Delete assessment
        Assessment::where('student_id', $student->id)->where('session_id', active_session()->id)->where('term_id', active_term()->id)->delete();

        // Delete class student
        ClassStudent::where('student_id', $student->id)->where('session_id', active_session()->id)->where('term_id', active_term()->id)->delete();
    }
}
