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
use App\Models\ClassLevel;
use App\Models\TeacherSubjectClass;
use Auth;
use DB;

use App\Jobs\DoClassPosition;

class ProcessClassResult extends Component
{
    public $class_id, $allSubjectsInClassIsProcessed, $noOfStudents, $noOfResults, $subjectTeachersRemaining;
    
    
    
    public function process() {
        $this->updateAssessments();
        // $this->getClassPosition();
    }
    

    public function updateAssessments() {
        $assessment;
        $markObtainedArray = [];
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        $allStudentsInAClass = Student::where('class_code', $class_code)->where('status', 1)->get();
        // Log::info($allStudentsInAClass);
        $arrayColl = [];
        foreach ($allStudentsInAClass as $key => $student) {
            $resultObject = Result::where('student_id', $student->id)
                                ->where('class_code', $student->class_code)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('cumulative_percentage', "!=", 0);
            if($resultObject->count() != 0) {
            $markObtainable = 100*($resultObject->count());
            $markObtained = $resultObject->sum('cumulative_percentage');
            $markObtainedArray[$key] = $markObtained;
            $arrayColl[$key]['markObtainable'] = $markObtainable;
            $arrayColl[$key]['markObtained'] = $markObtained;
            
            $percentage = round($markObtained/$markObtainable *100, 2). "%";

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
        // $this->emit('swal:notify', [
        //     'title' => 'Subject Processed',
        //     'text' => json_encode($arrayColl),
        // ]);
        }
        $highestMarkInClass = max($markObtainedArray);
        $lowestMarkInClass = min($markObtainedArray);
        $averageMarkInClass = round(array_sum($markObtainedArray)/(count($markObtainedArray)));

        ClassTeacher::where('session_id', $current_session_id)
                    ->where('term_id', $current_term_id)
                    ->where('class_id', $this->class_id)
                    ->update(['result_processed' => 1]);

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
        
        DoClassPosition::dispatch($this->class_id);

    }
    

    public function getSubjectTeachersRemaining() {
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        $subjectTeachersRemaining = TeacherSubjectClass::where('class_code', $class_code)
                                                ->where('session_id', active_session()->id)
                                                ->where('term_id', active_term()->id)
                                                ->where('class_result_processed', 0)
                                                ->get();
        return $subjectTeachersRemaining;
    }

    public function mount() {
        $this->subjectTeachersRemaining = $this->getSubjectTeachersRemaining();
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
