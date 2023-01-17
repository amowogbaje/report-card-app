<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\Subject;
use App\Models\Student;
use App\Models\Result;
use DB;

use Auth;

class SubjectsOffered extends Component
{
    public $generalSubjects, $specificSubjects, $student, 
            $selectedSubjects = [];
    public function mount() 
    {
        $userId = Auth::user()->id;
        $student = Student::where('user_id', $userId)->where('active', 1)->first();
        $this->student = $student;
        $classStageId = $student->class_stage_id;
        $category = $student->category;
        $this->generalSubjects = Subject::where('class_stage_id', $classStageId)->where('category', NULL)->get();
        $this->specificSubjects = Subject::where('class_stage_id', $classStageId)->where('category', $category)->get();
    }

    public function store() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;

        $selectedSubjects = $this->selectedSubjects;
        foreach($selectedSubjects as $subjectId){
            $subjectAlreadyRegistered = DB::table('results')->where([
                'session_id' => $current_session_id,
                'term_id' => $current_term_id,
                'subject_id' => $subjectId,
                'class_id' => $this->student->class_id,
                'student_id' => $this->student->id,
            ])->count();
            if($subjectAlreadyRegistered !=0) {
                DB::table('results')->insert([
                    'session_id' => $current_session_id,
                    'term_id' => $current_term_id,
                    'subject_id' => $subjectId,
                    'class_id' => $this->student->class_id,
                    'student_id' => $this->student->id,
                    'totalca' => 0,
                    'total_score' => 0,
                ]);
            }
            
        }

        $this->emit('swal:notify', [
            'title' => "Your subjects have been successfully registed",
            'text' => "...",
            'icon' => 'success',
        ]);
        

    }

    public function confirmDelete($subjectId) {
        Result::where('session_id', active_session()->id)
                ->where('term_id', active_term()->id)
                ->where('subject_id', $subjectId)
                ->where('student_id', $this->student->id)
                ->delete();
        // $this->emit('swal:notify', [
        //     'title' => 'Do you really want to delete this course?',
        //     'text' => "....",
        //     // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        // ]);
    }
    public function render()
    {
        return view('livewire.student.subjects-offered');
    }
}
