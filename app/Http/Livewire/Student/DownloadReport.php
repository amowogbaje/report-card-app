<?php

namespace App\Http\Livewire\Student;


use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Student;
use Auth;

use Livewire\Component;

class DownloadReport extends Component
{
    public $checklist, $resultIsReady, $student_id, $student;

    public function check() {
        if($this->resultIsReady == 0) {
            $boolPhysicalAssessment = 0;
            $boolSkillAssessment = 0;
            $boolBehaviourAssessment = 0;
            $boolAcademicAssessment = 0;
            $boolTeacherComment = 0;
            $boolPrincipalComment = 0;
            $boolStudentPaymentComplete = 0;
            $current_session_id = active_session()->id;
            $current_term_id = active_term()->id;
            $studentAssessment = Assessment::where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->where('school_info_id', Auth::user()->school_info_id)
                                    ->where('student_id', $this->student_id)
                                    ->first();
            $physicalAssessment = $studentAssessment->physical_assessments;
            $behaviourAssessments = $studentAssessment->behavior_assessments;
            $skillAssessments = $studentAssessment->skill_assessments;
            $academicAssessments = $studentAssessment->academic_assessments;
            $academicAssessmentsArray = json_decode(html_entity_decode($academicAssessments), true);
            $teacherComment = $studentAssessment->class_teacher_comment;
            $principalComment = $studentAssessment->principal_comment;
            $boolStudentPaymentComplete = $this->student->payment_complete;
            if($physicalAssessment != "") {
                $boolPhysicalAssessment = 1;
                $this->checklist['physicalAssessmentsFilled'] = "checked";
            }
            if($behaviourAssessments != "") {
                $boolBehaviourAssessment = 1;
                $this->checklist['behaviourAssessmentsFilled'] = "checked";
            }
            if($skillAssessments != "") {
                $boolSkillAssessment = 1;
                $this->checklist['skillAssessmentsFilled'] = "checked";
            }
            if($academicAssessmentsArray['markObtained'] != "Not Ready") {
                $boolAcademicAssessment = 1;
                $this->checklist['academicAssessmentsFilled'] = "checked";
            }
            if($principalComment != "") {
                $boolPrincipalComment = 1;
                $this->checklist['principalCommentFilled'] = "checked";
            }
            if($teacherComment != "") {
                $boolTeacherComment = 1;
                $this->checklist['teacherCommentFilled'] = "checked";
            }
            
            if($boolStudentPaymentComplete) {
                $this->checklist['student_payment_complete'] = "checked";
            }
            
            $caseOne = $boolAcademicAssessment;
            $caseOne*= $boolBehaviourAssessment; 
            // $caseOne*= $boolPhysicalAssessment;
            $caseOne*= $boolSkillAssessment;
            $caseOne*= $boolTeacherComment;
            $caseOne*= $boolPrincipalComment;
            if(Auth::user()->role != 'admin') {
                $caseOne *= $boolStudentPaymentComplete;
            }
            $caseTwo = $boolAcademicAssessment;
            $caseTwo += $boolBehaviourAssessment;
            // $caseTwo += $boolPhysicalAssessment;
            $caseTwo += $boolSkillAssessment;
            $caseTwo += $boolTeacherComment;
            $caseTwo += $boolPrincipalComment;
            if(Auth::user()->role != 'admin') {
                $caseTwo += $boolStudentPaymentComplete;
            }
            if($caseTwo > 0) $caseTwo = 1;
    
            if($caseOne) {
                $this->resultIsReady = 1;
                $url = "/'student/'.$this->student->id.'/download-result";
                $this->render();
                return redirect()->route('student.download-result', ['student_id' => $this->student->id]);
            }
            elseif($caseTwo) {$this->resultIsReady = 0;}
        }
        

    }
    public function mount() {
        $this->checklist = [];
        $this->checklist['skillAssessmentsFilled'] = "";
        $this->checklist['behaviourAssessmentsFilled'] = "";
        $this->checklist['physicalAssessmentsFilled'] = "";
        $this->checklist['academicAssessmentsFilled'] = "";
        $this->checklist['teacherCommentFilled'] = "";
        $this->checklist['principalCommentFilled'] = "";
        $this->checklist['student_payment_complete'] = "";
        $this->student = Student::where('id', $this->student_id)->first();
        
        $boolPhysicalAssessment = 0;
            $boolSkillAssessment = 0;
            $boolBehaviourAssessment = 0;
            $boolAcademicAssessment = 0;
            $boolTeacherComment = 0;
            $boolPrincipalComment = 0;
            $boolStudentPaymentComplete = 0;
            $current_session_id = active_session()->id;
            $current_term_id = active_term()->id;
            $studentAssessment = Assessment::where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->where('school_info_id', Auth::user()->school_info_id)
                                    ->where('student_id', $this->student_id)
                                    ->first();
            $physicalAssessment = $studentAssessment->physical_assessments;
            $behaviourAssessments = $studentAssessment->behavior_assessments;
            $skillAssessments = $studentAssessment->skill_assessments;
            $academicAssessments = $studentAssessment->academic_assessments;
            $academicAssessmentsArray = json_decode(html_entity_decode($academicAssessments), true);
            $teacherComment = $studentAssessment->class_teacher_comment;
            $principalComment = $studentAssessment->principal_comment;
            $boolStudentPaymentComplete = $this->student->payment_complete;
            if($physicalAssessment != "") {
                $boolPhysicalAssessment = 1;
                $this->checklist['physicalAssessmentsFilled'] = "checked";
            }
            if($behaviourAssessments != "") {
                $boolBehaviourAssessment = 1;
                $this->checklist['behaviourAssessmentsFilled'] = "checked";
            }
            if($skillAssessments != "") {
                $boolSkillAssessment = 1;
                $this->checklist['skillAssessmentsFilled'] = "checked";
            }
            if($academicAssessmentsArray['markObtained'] != "Not Ready") {
                $boolAcademicAssessment = 1;
                $this->checklist['academicAssessmentsFilled'] = "checked";
            }
            if($principalComment != "") {
                $boolPrincipalComment = 1;
                $this->checklist['principalCommentFilled'] = "checked";
            }
            if($teacherComment != "") {
                $boolTeacherComment = 1;
                $this->checklist['teacherCommentFilled'] = "checked";
            }
            
            if($boolStudentPaymentComplete) {
                $this->checklist['student_payment_complete'] = "checked";
            }

    }
    public function render()
    {
        return view('livewire.student.download-report');
    }
}
