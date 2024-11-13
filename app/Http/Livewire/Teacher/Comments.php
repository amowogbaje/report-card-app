<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Teacher;
use App\Models\User;
use App\Models\ClassTeacher;
use Auth;

class Comments extends Component
{
    public $student_id, $class_teacher_comment, $class_teacher_signature, $overall_attendance, $student_attendance;
    protected $rules = [
        'class_teacher_comment' => 'required|string',
        'overall_attendance' => 'required|string',
        'class_teacher_comment' => 'required|string',
    ];
    public function mount() {

        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $this->class_teacher_comment = $assessment->first()->class_teacher_comment;
            $this->student_attendance = $assessment->first()->student_attendance;
            $this->overall_attendance = $assessment->first()->overall_attendance;
            $teacherId = ClassTeacher::where('class_id', $assessment->first()->class_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('session_id', $current_session_id)
                                        ->first()->teacher_id;
            $teacheruserId = Teacher::where('id', $teacherId)->first()->user_id;
            $class_teacher_signature = User::where('id', $teacheruserId)->first()->signature_url;
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
            $newAssessment->class_id = Student::where('id', $this->student_id)->first()->class_id;
            $newAssessment->class_teacher_comment = $this->class_teacher_comment;
            $newAssessment->student_attendance = $this->student_attendance;
            $newAssessment->overall_attendance = $this->overall_attendance;
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Comment has been saved",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update([
                'class_teacher_comment' => $this->class_teacher_comment,
                'student_attendance' => $this->student_attendance,
                'overall_attendance' => $this->overall_attendance
            ]);
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
