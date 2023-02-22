<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Teacher;
use App\Models\ClassLevel;
use App\Models\TeacherSubjectClass;
use Auth;

class DashboardController extends Controller
{

    public function setup() {
        
    }
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


    public function timetable() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $initialArray = collect();
        // $noOfClass = ClassLevel::count();
        $noOfClass = TeacherSubjectClass::where('session_id', $current_session_id)
        ->where('term_id', $current_term_id)->distinct()->count('class_id');
        $teacherSubjectAlloc = TeacherSubjectClass::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)->get();
        $timetable = [];
        foreach($teacherSubjectAlloc as $teachersubject) {
            for ($i=0; $i < $teachersubject->periods; $i++) { 
                $initialArray->push($teachersubject);
            }
        }

        $aCounter = 1; $period = 1; $day = 1;
        
        

        foreach($initialArray as $teacherSubject) {
            
            if($aCounter%$noOfClass == 1 && $aCounter>1 ) {$period++; $aCounter = 1;}
            if($period%8 == 1 && $period>1 ) {$day++; $period = 1;}
            
            // $className = "".$teacherSubject->class->shortname;
            // $subjectName = "".$teacherSubject->subject->name;
            if(array_key_exists("day".$day, $timetable)) {
                if(array_key_exists("period".$period, $timetable["day".$day])) {
                    if($this->noDupClassOrTeacher($timetable["day".$day]["period".$period], $teacherSubject)) {
                        $timetable["day".$day]["period".$period][$aCounter] = $teacherSubject;
                    }
                    else {
                        $initialArray->shift($teacherSubject);
                        $initialArray->push($teacherSubject);
        
                    }
                }
                
            }
            else {
                $timetable["day".$day]["period".$period][$aCounter] = $teacherSubject;
            }
            
            
            $aCounter++;
        }

        return json_encode($timetable);

    }

    public function noDupClassOrTeacher($array, $object){
        foreach ($array as $objectInArray) {
            if($objectInArray->teacher_id == $object->teacher_id || $objectInArray->class_id == $object->class_id) {
                return false;
            }
            else {
                return true;
            }
        }
    }

    // public function subjects() {}
}
