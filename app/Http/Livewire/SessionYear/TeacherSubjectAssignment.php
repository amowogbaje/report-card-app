<?php

namespace App\Http\Livewire\SessionYear;

use App\Models\TeacherSubjectClass;
use App\Models\Subject;

use Livewire\Component;

class TeacherSubjectAssignment extends Component
{
    public $teachersubjects, $noOfSubjectClassesAssigned, $noOfSubjectsPerClass = 0;

    public function mount() {
        $subjects = Subject::all();
        foreach($subjects as $subject) {
            $this->noOfSubjectsPerClass+= $subject->noOfClass($subject->class_stage_id);
        }
        $this->noOfSubjectClassesAssigned = TeacherSubjectClass::where('session_id', active_session()->id)
                                            ->where('term_id', active_term()->id)->count();
        if(isset(active_session()->id)) {
            $this->teachersubjects = TeacherSubjectClass::where('session_id', active_session()->id)
                                        ->where('term_id', active_term()->id)->get();
        }
        else {
            $this->teachersubjects = null;
        }
        
    }
    public function render()
    {
        return view('livewire.session-year.teacher-subject-assignment');
    }
}
