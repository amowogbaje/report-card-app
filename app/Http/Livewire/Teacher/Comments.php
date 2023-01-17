<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use Auth;

class Comments extends Component
{
    public $student_id, $class_teacher_comment;
    protected $rules = [
        'class_teacher_comment' => 'required|string',
    ];
    public function mount() {

        $current_session_id = active_session()->id;
        $current_term_id = active_session()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $this->class_teacher_comment = $assessment->first()->class_teacher_comment;
        }
    }
    public function store() {
        $params = $this->validate();
        $current_session_id = SessionYear::where('active', true)->first()->id;
        $current_term_id = Term::where('active', true)->first()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() == 0) {
            $newAssessment = new Assessment;
            $newAssessment->session_id = $current_session_id;
            $newAssessment->term_id = $current_term_id;
            $newAssessment->student_id = $this->student_id;
            $newAssessment->school_info_id = Auth::user()->school_info_id;
            $newAssessment->class_teacher_comment = $this->class_teacher_comment;
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Comment has been saved",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['class_teacher_comment' => $this->class_teacher_comment]);
            $this->emit('toast:success', [
                'text' => "Your Comment has been updated",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "There has been an error contact the developer",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
    }
    public function render()
    {
        return view('livewire.teacher.comments');
    }
}
