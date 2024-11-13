<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use Auth;

class StudentBehaviourAssessment extends Component
{
    public $student_id, $punctuality, $class_attendance, $reliability, $neatness,
            $politeness, $honesty, $relationship_with_others, $self_control, 
            $spirit_of_cooperation, $sense_of_responsibility, $attentiveness_in_class,
            $initiative, $organisation_ability, $perseverance;
    public $behaviourAssessments;

    protected $rules = [
        'punctuality' => 'required|string',
        'class_attendance' => 'required|string',
        'reliability' => 'required|string',
        'neatness' => 'required|string',
        'politeness' => 'required|string',
        'honesty' => 'required|string',
        'relationship_with_others' => 'required|string',
        // 'self_control' => 'required|string',
        // 'spirit_of_cooperation' => 'required|string',
        'sense_of_responsibility' => 'required|string',
        'attentiveness_in_class' => 'required|string',
        // 'initiative' => 'required|string',
        'organisation_ability' => 'required|string',
        // 'perseverance' => 'required|string',
    ];

    public function store() {
        $params = $this->validate();
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
            $newAssessment->behavior_assessments = json_encode($params);
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Behaviour Assessment has been saved",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['behavior_assessments' => json_encode($params)]);
            $this->emit('toast:success', [
                'text' => "Your Behaviour Assessment has been updated",
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
   
    public function mount($student_id) {
        $this->student_id = $student_id;
        $behaviourAssessments['punctuality'] = 'Punctuality';
        $behaviourAssessments['class_attendance'] = 'Class Attendance';
        $behaviourAssessments['reliability'] = 'Reliability';
        $behaviourAssessments['neatness'] = 'Neatness';
        $behaviourAssessments['politeness'] = 'Politeness';
        $behaviourAssessments['honesty'] = 'Honesty';
        $behaviourAssessments['relationship_with_others'] = 'Relationship with Others';
        // $behaviourAssessments['self_control'] = 'Self Control';
        // $behaviourAssessments['spirit_of_cooperation'] = 'Spirit of Cooperation';
        $behaviourAssessments['sense_of_responsibility'] = 'Sense of Responsibility';
        $behaviourAssessments['attentiveness_in_class'] = 'Attentiveness in Class';
        // $behaviourAssessments['initiative'] = 'Initiative';
        $behaviourAssessments['organisation_ability'] = 'Organisation Ability';
        // $behaviourAssessments['perseverance'] = 'Perseverance';
        $this->behaviourAssessments = $behaviourAssessments;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $studentAssessment = $assessment->first();
            $behaviourAssessment = $studentAssessment->behavior_assessments;
            if($behaviourAssessment != "") {
                $behaviourAssessmentArray = json_decode(html_entity_decode($behaviourAssessment), true);
                $this->punctuality = $behaviourAssessmentArray['punctuality'];
                $this->class_attendance = $behaviourAssessmentArray['class_attendance'];
                $this->reliability = $behaviourAssessmentArray['reliability'];
                $this->neatness = $behaviourAssessmentArray['neatness'];
                $this->politeness = $behaviourAssessmentArray['politeness'];
                $this->honesty = $behaviourAssessmentArray['honesty'];
                $this->relationship_with_others = $behaviourAssessmentArray['relationship_with_others'];
                // $this->self_control = $behaviourAssessmentArray['self_control'];
                // $this->spirit_of_cooperation = $behaviourAssessmentArray['spirit_of_cooperation'];
                $this->sense_of_responsibility = $behaviourAssessmentArray['sense_of_responsibility'];
                $this->attentiveness_in_class = $behaviourAssessmentArray['attentiveness_in_class'];
                // $this->initiative = $behaviourAssessmentArray['initiative'];
                $this->organisation_ability = $behaviourAssessmentArray['organisation_ability'];
                // $this->perseverance = $behaviourAssessmentArray['perseverance'];
            }
            // $this->age = $assessment->first()->behaviour_assessments;
        }
        // elseif($assessment->count() == 0) 
    }


    public function render()
    {
        return view('livewire.teacher.student-behaviour-assessment');
    }
}
