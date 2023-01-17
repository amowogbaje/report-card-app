<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Teacher;
use App\Models\ClassLevel;
use App\Models\TeacherSubjectClass;
use App\Models\SessionYear;
use App\Models\Term;

class TeacherProfile extends Component
{
    public $profileId;

    public function assignClass() {
        session()->flash('error','Something goes wrong while creating category!!');
    }
    public function render()
    {
        $classlevels = ClassLevel::all();
        $teacher = Teacher::where('user_id', $this->profileId)->first();
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacherSubjectClassObject = TeacherSubjectClass::where('teacher_id', $teacher->id)
                                        ->where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id);
        $noOfSubjects = $teacherSubjectClassObject->count();
        $subjectAndClasses = $teacherSubjectClassObject->get();
        return view('livewire.teacher.teacher-profile', compact('teacher', 'classlevels', 'noOfSubjects', 'subjectAndClasses'));
    }
}
