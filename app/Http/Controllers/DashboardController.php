<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\SessionYear;
use App\Models\SubjectTerm;
use App\Models\Term;
use App\Models\Teacher;
use App\Models\ClassStudent;
use App\Models\ClassLevel;
use App\Models\Assessment;
use App\Models\TeacherSubjectClass;
use App\Jobs\ActiveResultForStudent;
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
    
    public function littleErrands() {
        // $student = Student::where('user_id',92)->first();
        
        $students = Student::where('status', 1)->get();
        
        // return $students;
            ActiveResultForStudent::dispatch($students);
       
        
        // $studentClassCode = $student->class_code;
        // $promotionStudentClassCode = sprintf("%03d", ($studentClassCode+1));
        // return [$studentClassCode, $promotionStudentClassCode];
        
        // $numberOfStudent = Student::where('class_code', '001')
        //                     ->orWhere('class_code', '002')
        //                     ->orWhere('class_code', '004')
        //                     ->orWhere('class_code', '005')
        //                     ->count();
        // return $numberOfStudent;
        
        
        // updating assessment with class_id code
        // $assessments = Assessment::where('class_id', NULL)->where('term_id', 3)->get();
        // return $assessments;
        // foreach($assessments as $assessment) {
        //     $studentClassId = Student::where('id', $assessment->student_id)->first()->class_id;
        //     Assessment::where('student_id', $assessment->student_id)->update([
        //         'class_id' => $studentClassId
        //         ]);
        // }
        
    }
    
    public function copysubjectsAndAllocations() {
        $subjectTerms = SubjectTerm::where('session_id', 2)->where('term_id', 2)->get();
        
        $newsubjectTerm = [];

        foreach ($subjectTerms as $subjectTerm) {
            $newsubjectTerm[] = [
                'session_id' => $subjectTerm->session_id,
                'term_id' => 3,
                'subject_id' => $subjectTerm->subject_id,
                'class_stage_id' => $subjectTerm->class_stage_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        SubjectTerm::insert($newsubjectTerm);
        
        $allocations = TeacherSubjectClass::where('session_id', 2)->where('term_id', 2)->get();
        
        $newAllocations = [];

        foreach ($allocations as $allocation) {
            $newAllocations[] = [
                'session_id' => $allocation->session_id,
                'term_id' => 3,
                'teacher_id' => $allocation->teacher_id,
                'subject_id' => $allocation->subject_id,
                'class_id' => $allocation->class_id,
                'class_code' => $allocation->class_code,
                'periods' => $allocation->periods,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        TeacherSubjectClass::insert($newAllocations);
    }
    public function classTeacherCommentsMissing() {
        $termsAndSession = ClassStudent::groupBy('session_id', 'term_id')->distinct()
                                                    // ->where('term_id', '!=', active_term()->id)
                                                    ->get();
        
        $missing_assessments = Assessment::where('class_teacher_comment', NULL)->orderBy('class_id', 'asc')->where('term_id', active_term()->id)->get();
        $missing_principal_assessments = Assessment::where('principal_comment', NULL)->orderBy('class_id', 'asc')->where('term_id', active_term()->id)->get();
        return view('admin.class_teacher_comments_missing', compact('missing_assessments', 'termsAndSession', 'missing_principal_assessments'));
        // foreach($assessments as $assessment) {
        //     $studentClassId = Student::where('id', $assessment->student_id)->first()->class_id;
        //     Assessment::where('student_id', $assessment->student_id)->update([
        //         'class_id' => $studentClassId
        //         ]);
        // }
        
    }

    public function subjectTeachers() {
        $termsAndSession = ClassStudent::groupBy('session_id', 'term_id')->distinct()
                                                    // ->where('term_id', '!=', active_term()->id)
                                                    ->get();
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacherSubjectClassObject = TeacherSubjectClass::where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id);
        $noOfSubjects = $teacherSubjectClassObject->count();
        $subjectAndClasses = $teacherSubjectClassObject->get();
        return view('admin.subject-teacher', compact('subjectAndClasses', 'noOfSubjects', 'termsAndSession'));
    }

    public function timetable() {
        session()->forget('dynamic_term_id');
        session()->forget('dynamic_session_id');
        
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

    public function setSessionTerm(Request $request) {
        // return "$request->sessionterm";
        if($request->sessionterm) {
            $classstudent = ClassStudent::where('id', $request->sessionterm)->first();
            session([
                    'dynamic_term_id' => $classstudent->term_id,
                    'dynamic_session_id' => $classstudent->session_id,
                    ]);
        
            return redirect()->back()->with('success', 'Session and Term set to '. active_session()->name." ". active_term()->name. " Term" );
        }
        else {
            return redirect()->back()->with('failure', 'Session and Term not selected');
        }
    }
}
