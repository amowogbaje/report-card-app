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
use DB;

use App\Jobs\DoClassPosition;

class ProcessClassResult extends Component
{
    public $class_id, $allSubjectsInClassIsProcessed, $noOfStudents, $noOfResults, $subjectTeachersRemaining;
    
    public function calcPosition(array $scores, $studentScore) {
        $position = "1st";
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
    
    
    public function process() {
        $this->updateAssessments();
        // $this->getClassPosition();
    }
    

    public function updateAssessments() {
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
            $markObtained = $resultObject->sum('cumulative_percentage');
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
    
    public function getClassPosition() {
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
            $allPercentages[] = $academicAssessmentsArray['percentage'];
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
            $position_in_class = $this->calcPosition($allPercentages, $academicAssessmentsArray['percentage']);
            $assessment->update(['position_in_class' => $position_in_class]);
            }
        }
        
    }

    public function getSubjectTeachersRemaining() {
        $subjectTeachersRemaining = TeacherSubjectClass::where('class_id', $this->class_id)
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
