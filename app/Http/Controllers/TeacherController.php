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

}
