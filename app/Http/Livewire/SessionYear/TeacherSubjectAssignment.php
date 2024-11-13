<?php

namespace App\Http\Livewire\SessionYear;

use App\Models\TeacherSubjectClass;
use App\Models\Subject;
use App\Models\ClassTeacher;
use App\Models\Result;
use App\Models\Term;
use App\Models\SessionYear;
use DB;

use Livewire\Component;

class TeacherSubjectAssignment extends Component
{
    public $teachersubjects, $noOfSubjectClassesAssigned, $subject_id;

    public function mount() {
        
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
    
    
    public function delete($id) {
        $teacherSubject = TeacherSubjectClass::where('id', $id)->first();
        $subjectName = $teacherSubject->subject->name;
        $className = $teacherSubject->class->shortname;
        $resultS = Result::where('class_id', $teacherSubject->class_id)
                        ->where('subject_id', $teacherSubject->subject_id)
                        ->delete();
        TeacherSubjectClass::where('id', $teacherSubject->id)->delete();
        $this->emit('toast:success', [
            'text'=> $subjectName." for ".$className." have been successfully deleted..",
            'modalID' => "#copy_allocation_modal"
        ]);
        $this->mount();
        $this->render();
    }
    public function render()
    {
        return view('livewire.session-year.teacher-subject-assignment');
    }
}
