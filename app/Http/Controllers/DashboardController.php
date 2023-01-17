<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Teacher;
use App\Models\TeacherSubjectClass;
use Auth;

class DashboardController extends Controller
{
    //
    // public $current_session = active_session();
    public function admin() {
        $current_session_object = active_session();
        
        if(!$current_session_object) 
        { 
            $current_session = 'Nil';
        }
        else {
            $current_session = $current_session_object->name;
        }

        $current_term_object = active_term();
        if(!$current_term_object) 
        { 
            $current_term = 'No term Activated';
        }
        else {
            $current_term = $current_term_object->name;
        }

        $noOfTeachers = User::where('role', 'teacher')->count() - 1;
        $noOfStudents = User::where('role', 'student')->count();
        $noOfPaidStudents = Student::where('payment_complete', 1)->count();
        return view('admin.dashboard', compact('current_session', 'current_term', 'noOfStudents', 'noOfTeachers', 'noOfPaidStudents'));
    }

    public function teacher() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacher_id = Teacher::where('user_id', Auth::user()->id)->first()->id;
        $teacherSubjectClassObject = TeacherSubjectClass::where('teacher_id', $teacher_id)
                                        ->where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id);
        $noOfSubjects = $teacherSubjectClassObject->count();
        $subjectAndClasses = $teacherSubjectClassObject->get();
        return view('teachers.dashboard', compact('subjectAndClasses', 'noOfSubjects'));
    }

    public function student() {
        return view('students.dashboard');
    }

    // public function subjects() {}
}
