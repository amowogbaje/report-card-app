<?php

namespace App\Http\Livewire;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Student;
use App\Models\Classlevel;
use Auth;

use Livewire\Component;

class PrincipalComments extends Component
{
    public $student_id, $principal_comment, $class_id, $classlevels;
    protected $rules = [
        'principal_comment' => 'required|string',
    ];

    public function mount() {
        $student = Student::where('id',$this->student_id)->first();
        $this->classlevels = Classlevel::all();
        // $this->classlevels = Classlevel::where('id', '>' $student->class_id);
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $this->principal_comment = $assessment->first()->principal_comment;
        }
    }
    public function store() {
        $params = $this->validate();
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
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
            $newAssessment->principal_comment = $this->principal_comment;
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Comment has been saved",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['principal_comment' => $this->principal_comment]);
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

    public function promote() {
        $this->validate([
            'class_id' => 'required'
        ]);
        $student = Student::find($this->student_id);
        $student->class_id = $this->class_id;
        $student->save();
        $this->emit('toast:success', [
            'text' => "Student successfully promoted",
            'modalID' => "#behaviour_assessment_modal"
        ]);
    }

    public function render()
    {
        return view('livewire.principal-comments');
    }
}
