<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Student;
use Auth;

class PhysicalAssessment extends Component
{
    public $student_id, $age, $weight, $height;

    protected $rules = [
        'weight' => 'required|string',
        'height' => 'required|string',
    ];


    public function store() {
        $params = $this->validate();
        $params['age'] = $this->age;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        $countAssessment = $assessment->count();
        if($assessment->count() == 0) {
            $newAssessment = new Assessment;
            $newAssessment->session_id = $current_session_id;
            $newAssessment->term_id = $current_term_id;
            $newAssessment->student_id = $this->student_id;
            $newAssessment->class_id = Student::where('id', $this->student_id)->first()->class_id;
            $newAssessment->school_info_id = Auth::user()->school_info_id;
            $newAssessment->physical_assessments = json_encode($params);
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Physical Assessment has been saved",
                'modalID' => "#physical_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['physical_assessments' => json_encode($params)]);
            $this->emit('toast:success', [
                'text' => "Your Physical Assessment has been updated",
                'modalID' => "#physical_assessment_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "There has been an error contact the developer",
                'modalID' => "#physical_assessment_modal"
            ]);
        }

    }


    public function mount($student_id) {
        $this->student_id = $student_id;
        $current_session_id = active_session()->id;
        $this->age = Student::where('id', $student_id)->first()->user->age;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $studentAssessment = $assessment->first();
            $physicalAssessment = $studentAssessment->physical_assessments;
            if($physicalAssessment != "") {
                $physicalAssessmentArray = json_decode(html_entity_decode($physicalAssessment), true);
                $this->weight = $physicalAssessmentArray['weight'];
                $this->height = $physicalAssessmentArray['height'];
            }
            // $this->age = $assessment->first()->physical_assessments;
        }
        // elseif($assessment->count() == 0) 
    }

    public function cancel() {
        $this->age = '';
        $this->weight = '';
        $this->height = '';
    }

    public function render()
    {
        
        return view('livewire.student.physical-assessment');
    }
}
