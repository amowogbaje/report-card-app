<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Subject;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\Result;
use DB;

use Auth;

class SubjectRegistration extends Component
{
    public $generalSubjects, $class_id, $subject, $students, $classLevel, 
            $selectedStudents = [];
    public function mount($class_id, $subject_id) 
    {
        
        // $userId = Auth::user()->id;
        $this->class_id = $class_id;
        $this->subject_id = $subject_id;
        $students = Student::where('class_id', $class_id)->get();
        $this->subject = Subject::where('id', $subject_id)->first();
        $classLevel = ClassLevel::where('id', $class_id)->first();
        $this->students = $students;
        $this->classLevel = $classLevel;
    }

    public function store() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        
        
        $selectedStudents = $this->selectedStudents;
        foreach($selectedStudents as $studentId){
            $studentAlreadyRegistered = DB::table('results')->where([
                'session_id' => $current_session_id,
                'term_id' => $current_term_id,
                'subject_id' => $this->subject->id,
                'class_id' => $this->class_id,
                'class_code' => $class_code,
                'student_id' => $studentId,
            ])->count();
            if($studentAlreadyRegistered ==0) {
                DB::table('results')->insert([
                    'session_id' => $current_session_id,
                    'term_id' => $current_term_id,
                    'subject_id' => $this->subject->id,
                    'class_id' => $this->class_id,
                    'class_code' => $class_code,
                    'student_id' => $studentId,
                    'totalca' => 0,
                    'total_score' => 0,
                ]);
            }
            
        }
        // $noOfResults = DB::table('results')->count();
        // $this->emit('swal:notify', [
        //     'title' => "Class Id ". json_encode($noOfResults),
        //     'text' => "...",
        //     'icon' => 'success',
        // ]);

        $this->emit('swal:notify', [
            'title' => "Your subjects have been successfully registered",
            'text' => "...",
            'icon' => 'success',
        ]);
        

    }

    public function confirmDelete($studentId) {
        Result::where('session_id', active_session()->id)
                ->where('term_id', active_term()->id)
                ->where('subject_id', $this->subject->id)
                ->where('student_id', $studentId)
                // ->where('class_id', $this->class_id)
                ->delete();
        $this->emit('toast:success', [
            // 'title' => 'Student removed from Course Registered',
            'text' => "Student removed from Course Registered",
            // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        ]);
    }
    public function render()
    {
        return view('livewire.teacher.subject-registration');
    }
}
