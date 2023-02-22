<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Result;
use App\Models\Student;
use App\Models\Assessment;
use App\Models\ClassAssessment;
use App\Models\ClassTeacher;
use App\Models\TeacherSubjectClass;
use Auth;

class ProcessClassResult extends Component
{
    public $class_id , $allSubjectsInClassIsProcessed, $noOfStudents, $noOfResults;

    public function process() {
        $assessment;
        $markObtainedArray = [];
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $allStudentsInAClass = Student::where('class_id', $this->class_id)->where('status', 1)->get();
        foreach ($allStudentsInAClass as $key => $student) {
            $resultObject = Result::where('student_id', $student->id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id);
            $markObtainable = 100*($resultObject->count());
            if($current_term_id == 1 || $current_term_id == 2) {
                $markObtained = $resultObject->sum('total_score');
            }
            elseif($current_session_id == 3){
                $markObtained = $resultObject->sum('cumulative_percentage');
            }
            $markObtainedArray[$key] = $markObtained;
            $percentage = round($markObtained/$markObtainable *100). "%";

            $academicAssessment = json_encode(compact('percentage', 'markObtained', 'markObtainable'));

            $assessment = Assessment::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('student_id', $student->id)
                                        ->where('school_info_id', Auth::user()->school_info_id);
            $countAssessment = $assessment->count();
            if($assessment->count() == 0) {
                Assessment::insert([
                    'academic_assessments' => $academicAssessment,
                    'student_id' => $student->id,
                    'session_id' => $current_session_id,
                    'term_id' => $current_term_id,
                    'school_info_id' => Auth::user()->school_info_id,
                ]);
            }
            elseif($assessment->count() > 0) {
                $assessment->update(['academic_assessments' => $academicAssessment]);
            }
        }

        $highestMarkInClass = max($markObtainedArray);
        $lowestMarkInClass = min($markObtainedArray);
        $averageMarkInClass = round(array_sum($markObtainedArray)/(count($markObtainedArray)));

        ClassTeacher::where('session_id', $current_session_id)
                    ->where('term_id', $current_term_id)
                    ->where('class_id', $this->class_id)
                    ->update(['result_processed' => 0]);

        $classAssessmentObject = ClassAssessment::where('session_id', $current_session_id)
                                                ->where('term_id', $current_term_id)
                                                ->where('class_id', $this->class_id);
        $countClassAssessment = $classAssessmentObject->count();
        if($countClassAssessment == 0) {
            ClassAssessment::insert([
                'highest_score' => $highestMarkInClass,
                'lowest_score' => $lowestMarkInClass,
                'average_score' => $averageMarkInClass,
                'session_id' => $current_session_id,
                'term_id' => $current_term_id,
                'class_id' => $this->class_id
            ]);
        }

        elseif($countClassAssessment > 0) {
            $classAssessmentObject->update([
                'highest_score' => $highestMarkInClass,
                'lowest_score' => $lowestMarkInClass,
                'average_score' => $averageMarkInClass
            ]);
        }
        $this->emit('toast:notify', [
            'text' => "Your Academic Assessment has been saved",
        ]);

    }

    public function mount() {
        $allSubjectsInClassIsProcessed = false;
        $current_session_id = SessionYear::where('active', true)->first()->id;
        $current_term_id = Term::where('active', true)->first()->id;
        
        $allSubjectsInClassObjects = TeacherSubjectClass::where('class_id', $this->class_id)
                                                ->where('session_id', $current_session_id)
                                                ->where('term_id', $current_term_id);
        $noOfAllSubjectsInClass = $allSubjectsInClassObjects->count();
        $allResultProcessed = Result::where('class_id', $this->class_id)
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->distinct('subject_id')
                                    ->groupBy('student_id')
                                    ->count();
        $this->noOfResults = $allResultProcessed;
        $this->noOfStudents = $allStudentsInAClass = Student::where('class_id', $this->class_id)->count();
        $allSubjectsInClass = $allSubjectsInClassObjects->get();
        $allSubjectsInClassThatHasBeenProcessed = $allSubjectsInClassObjects->where('class_result_processed', 1)->count();
        if($allSubjectsInClassThatHasBeenProcessed == $noOfAllSubjectsInClass) {
            $allSubjectsInClassIsProcessed = true;
        }
        else {
            $allSubjectsInClassIsProcessed = false;
        }

        $this->allSubjectsInClassIsProcessed = $allSubjectsInClassIsProcessed;
    }


    public function render()
    {
        $noOfStudents = $this->noOfStudents;
        $noOfResults = $this->noOfResults;
        $allSubjectsInClassIsProcessed = $this->allSubjectsInClassIsProcessed;
        return view('livewire.teacher.process-class-result', compact('allSubjectsInClassIsProcessed', 'noOfStudents', 'noOfResults'));
    }
}
