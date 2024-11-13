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

use Auth;
use DB;

class DoClassPosition implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $class_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($class_id)
    {
        $this->class_id = $class_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $assessment;
        $allPercentages;
        $markObtainedArray = [];
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        $allStudentsInAClass = Student::where('class_code', $class_code)->where('status', 1)->get();
        foreach ($allStudentsInAClass as $key => $student) {
            $assessment = Assessment::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('student_id', $student->id)
                                        ->where('school_info_id', Auth::user()->school_info_id);
            $countAssessment = $assessment->count();
            if($assessment->count() > 0) {
                $academic_assessments = $assessment->first()->academic_assessments;
            if($academic_assessments != "") {
                $academicAssessmentsArray = json_decode(html_entity_decode($academic_assessments), true);
            }
            $allPercentages[] = floatval($academicAssessmentsArray['percentage']);
            // $assessment->update(['academic_assessments' => $academicAssessment]);
            }
        }
        foreach ($allStudentsInAClass as $key => $student) {
            $assessment = Assessment::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('student_id', $student->id)
                                        ->where('school_info_id', Auth::user()->school_info_id);
            $countAssessment = $assessment->count();
            if($assessment->count() > 0) {
                $academic_assessments = $assessment->first()->academic_assessments;
            if($academic_assessments != "") {
                $academicAssessmentsArray = json_decode(html_entity_decode($academic_assessments), true);
            }
            $position_in_class = $this->calcPosition($allPercentages, floatval($academicAssessmentsArray['percentage']));
            $assessment->update(['position_in_class' => $position_in_class]);
            }
        }
        
    }
    
    public function calcPosition(array $scores, $studentScore) {
        $position = "NA";
        rsort($scores);
        $scorePosition = [];
        
        // dd(($scores));
        foreach ($scores as $pos => $score) {
            $pos = $pos + 1;
            $pos = "$pos";
            if(strlen($pos) == 1) {
                if(substr($pos, strlen($pos)-1)  == 1 ) { $position = $pos ."<sup>st</sup>"; }
                elseif(substr($pos, strlen($pos)-1) == 2) { $position = $pos ."<sup>nd</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 3) { $position = $pos ."<sup>rd</sup>";}
                else {$position = $pos."<sup>th<sup>";}
            }
            else if(strlen($pos) >= 2) {
                if(substr($pos, strlen($pos)-1)  == 1 && substr($pos,0,1) !=1) { $position = $pos ."<sup>st</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 2 && substr($pos,0,1) !=1) { $position = $pos ."<sup>nd</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 3 && substr($pos,0,1) !=1) { $position = $pos ."<sup>rd</sup>";}
                else {$position = $pos."<sup>th<sup>";}
            }

            $scorePosition["$position"] = $score;
        }

        

        $noDuplicates = array_unique($scorePosition);
        // return json_encode($noDuplicates);
        return array_search($studentScore, $noDuplicates);

    }
}
