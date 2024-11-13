<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Result;
use App\Models\ClassLevel;
use App\Models\Assessment;
use App\Models\ClassAssessment;
use Auth;

class ProfileController extends Controller
{
    //s
    public function viewStudentProfile($user_id){
        $userId = $user_id;
        return view('student-profile-page', compact('userId'));
    }

    public function academicReport($studentId) {
        $resultIsReady = 0;
        $academicAssessmentsArray = [];

        
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $student = Student::where('id', $studentId)->first();

        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $student->id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        $countAssessment = $assessment->count();
        if($assessment->count() == 0) {
            return back()->with('error', 'Academic Report will not open because Physical Assessment has not been filled');
        }

        $studentAssessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('school_info_id', Auth::user()->school_info_id)
                                ->where('student_id', $student->id)
                                ->first();
        $classAssessment = ClassAssessment::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('class_id', $student->class_id)
                                        ->first();
        $physicalAssessment = $studentAssessment->physical_assessments;
        $behaviourAssessments = $studentAssessment->behavior_assessments;
        $skillAssessments = $studentAssessment->skill_assessments;
        $academicAssessments = $studentAssessment->academic_assessments;
        $position_in_class = $studentAssessment->position_in_class;
        if($physicalAssessment != "") {
            // $checklist['physicalAssessmentsFilled'] = "checked";
            $physicalAssessmentArray = json_decode(html_entity_decode($physicalAssessment), true);
        }
        if($behaviourAssessments != "") {
            // $checklist['behaviourAssessmentsFilled'] = "checked";
            $behaviourAssessmentsArray = json_decode(html_entity_decode($behaviourAssessments), true);
        }
        if($skillAssessments != "") {
            // $checklist['skillAssessmentsFilled'] = "checked";
            $skillAssessmentsArray = json_decode(html_entity_decode($skillAssessments), true);
        }
        if($academicAssessments != "") {
            // $checklist['academicAssessmentsFilled'] = "checked";
            $academicAssessmentsArray = json_decode(html_entity_decode($academicAssessments), true);
        }
        

        if($physicalAssessment != "" && $behaviourAssessments != "" && $skillAssessments != "" && $academicAssessments != "") {
            $resultIsReady = 1;
        }
        elseif($physicalAssessment == NULL || $behaviourAssessments == NULL || $skillAssessments == NULL || $academicAssessments ==NULL) {
            $resultIsReady = 0;
        }
        $results = Result::where('session_id', $current_session_id)
                        ->where('term_id', $current_term_id)
                        ->where('student_id', $studentId)
                        ->where('class_id', $student->class_id)
                        ->get();
                        
        //test error
    //     foreach ($results as $result) {
    //     $classResultProcessed = $result->subjectTeacher($result->subject_id, $result->class_id);
    //     $classResultProcessedList[] = [
    //         'subject_id' => $result->subject_id,
    //         'class_id' => $result->class_id,
    //         'exam' => $result->exam,
    //         'term_id' => $result->term_id,
    //         'class_result_processed' => $classResultProcessed,
    //     ];
    // }

    // return $classResultProcessedList;
        // return $results;
        return view('student-academic-report', compact('student', 'results', 'studentAssessment','classAssessment','academicAssessmentsArray', 'resultIsReady', 'position_in_class'));
    }

    public function viewTeacherProfile($teacherId){
        return view('teacher-profile-page', compact('teacherId'));

    }
    public function editStudentProfile($user_id){
        $userId = $user_id;
        return view('student-profile-edit', compact('userId'));
    }
    public function editTeacherProfile($userId){
        $teacher = Teacher::where('user_id', $userId)->first();
        return view('teacher-profile-edit', compact('teacher'));
    }

    public function subjectOfferedByStudent() {
        return view('students.subjects-offered');
    }
    
    public function subjectRegistration($class_id, $subject_id) {
        return view('teachers.subject-registration', compact('class_id', 'subject_id'));
    }


    public function editTeacherAction(Request $request){

        $user_id = $request->user_id;
        $user = User::find($user_id);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->othernames = $request->othernames;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->guardian_phone = $request->phone;
            $user->student_phone = $request->student_phone;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->lga_origin = $request->lga_origin;
            $user->state_origin = $request->state_origin;
            $user->citizenship = $request->citizenship;
            $user->dob = $request->dob;
            // if($this->dob =="null")
            $user->save();
            if($user) {
                return back()->with('success', $request->firstname.' info has been Successfully edited');
            }
            else {
                return back()->with('error','Something goes wrong while updating....!!');
                // $this->resetFields();
            }

    }

    public function editStudentAction(Request $request) {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $student = Student::find($request->student_id);

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->othernames = $request->othernames;
            $user->email = $request->email;
            $user->phone = $request->phone;
            // $user->gender = $request->gender;
            $user->address = $request->address;
            $user->lga_origin = $request->lga_origin;
            $user->state_origin = $request->state_origin;
            $user->citizenship = $request->citizenship;
            $user->dob = $request->dob;
            // if($this->dob =="null")
            $user->save();
            if($user) {
                $student->user_id = $user->id;
                $student->guardian_phone = $request->guardian_phone;
                $student->student_phone = $request->phone;
                $student->class_id = $request->class_id;
                $student->category = $request->category;
                $student->guardian_name = $request->guardian_name;
                $student->guardian_address = $request->guardian_address;
                $student->save();
                return back()->with('success', $request->firstname.' info has been Successfully edited');
            }
            else {
                return back()->with('error','Something goes wrong while updating....!!');
                // $this->resetFields();
            }
    }
}
