<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TeacherSubjectClass;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Teacher;
use App\Models\ClassTeacher;
use App\Models\ClassLevel;
use DB;


use Auth;

class TeacherController extends Controller
{
    //
    

    public function subjects() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacher_id = Teacher::where('user_id', Auth::user()->id)->first()->id;
        $teacherSubjectClassObject = TeacherSubjectClass::where('teacher_id', $teacher_id)
                                        ->where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id);
        $noOfSubjects = $teacherSubjectClassObject->count();
        $subjectAndClasses = $teacherSubjectClassObject->get();
        return view('teachers.subjects', compact('subjectAndClasses', 'noOfSubjects'));
    }
    
    public function registerStudent(Request $request) {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $request->class_id)->first()->code;
        
        
        $selectedStudents = $request->selectedStudents;
        // return json_encode($selectedStudents);
        if (is_array($selectedStudents) && !empty($selectedStudents)) {
            foreach ($selectedStudents as $studentId) {
                $studentAlreadyRegistered = DB::table('results')->where([
                    'session_id' => $current_session_id,
                    'term_id' => $current_term_id,
                    'subject_id' => $request->subject_id,
                    'class_id' => $request->class_id,
                    'class_code' => $class_code,
                    'student_id' => $studentId,
                ])->count();
        
                if ($studentAlreadyRegistered == 0) {
                    DB::table('results')->insert([
                        'session_id' => $current_session_id,
                        'term_id' => $current_term_id,
                        'subject_id' => $request->subject_id,
                        'class_id' => $request->class_id,
                        'class_code' => $class_code,
                        'student_id' => $studentId,
                        'totalca' => 0,
                        'total_score' => 0,
                    ]);
                }
            }
        } else {
            // Handle the case where $selectedStudents is null or not an array
            Log::info('Selected students is either null or not an array.');
        }
        
        return back()->with('success', 'Students have been successfully registed');
        
        
        

    }

    public function classAssigned() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacher_id = Teacher::where('user_id', Auth::user()->id)->first()->id;
        $classTeacherObject = ClassTeacher::where('teacher_id', $teacher_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id);
        
        if($classTeacherObject->count() == 0) {
            $class_teacher_id = "no-class-assigned";
        }
        else {
            $class_teacher_id = $classTeacherObject->first()->class_id;
            
        }
                                
        // return $class_teacher_id;

        return view('teachers.class-assigned', compact('class_teacher_id'));
    }
    
    public function updateProfile(Request $request){

        $user_id = $request->user_id;
        $user = User::find($user_id);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->othernames = $request->othernames;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->lga_origin = $request->lga_origin;
            $user->state_origin = $request->state_origin;
            $user->citizenship = $request->citizenship;
            $user->dob = $request->dob;
            $user->save();
            if($user) {
                return back()->with('success', $request->firstname.' info has been Successfully edited');
            }
            else {
                return back()->with('error','Something goes wrong while updating....!!');
            }

    }

}
