<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use Auth;
class StudentSkillAssessment extends Component
{
    public $student_id, $hand_writing, $fluency, $games_sport_and_gymnastics, $handling_of_tools,
            $labour_and_workshop, $drawing_and_painting, $craft, $musical_skill;
    public $skillAssessments;

    protected $rules = [
        'hand_writing' => 'required|string',
        'fluency' => 'required|string',
        'games_sport_and_gymnastics' => 'required|string',
        'handling_of_tools' => 'required|string',
        'labour_and_workshop' => 'required|string',
        'drawing_and_painting' => 'required|string',
        'craft' => 'required|string',
        'musical_skill' => 'required|string',
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
            $newAssessment->school_info_id = Auth::user()->school_info_id;
            $newAssessment->skill_assessments = json_encode($params);
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Skill Assessment has been saved",
                'modalID' => "#skill_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['skill_assessments' => json_encode($params)]);
            $this->emit('toast:success', [
                'text' => "Your Skill Assessment has been updated",
                'modalID' => "#skill_assessment_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "There has been an error contact the developer",
                'modalID' => "#skill_assessment_modal"
            ]);
        }

    }
   
    public function mount($student_id) {
        $skillAssessments['hand_writing'] = 'Hand Writing';
        $skillAssessments['fluency'] = 'Fluency';
        $skillAssessments['games_sport_and_gymnastics'] = 'Games Sport and Gymnastics Writing';
        $skillAssessments['handling_of_tools'] = 'Handling of Tools';
        $skillAssessments['labour_and_workshop'] = 'Labour and Workshop';
        $skillAssessments['drawing_and_painting'] = 'Drawing and Painting';
        $skillAssessments['craft'] = 'Craft';
        $skillAssessments['musical_skill'] = 'Musical Skill';
        $this->skillAssessments = $skillAssessments;
        $this->student_id = $student_id;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $assessment = Assessment::where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $this->student_id)
                                ->where('school_info_id', Auth::user()->school_info_id);
        if($assessment->count() != 0) {
            $studentAssessment = $assessment->first();
            $skillAssessment = $studentAssessment->skill_assessments;
            if($skillAssessment != "") {
                $skillAssessmentArray = json_decode(html_entity_decode($skillAssessment), true);
                $this->hand_writing = 4;
                $this->games_sport_and_gymnastics = $skillAssessmentArray['games_sport_and_gymnastics'];
                $this->handling_of_tools = $skillAssessmentArray['handling_of_tools'];
                $this->labour_and_workshop = $skillAssessmentArray['labour_and_workshop'];
                $this->drawing_and_painting = $skillAssessmentArray['drawing_and_painting'];
                $this->craft = $skillAssessmentArray['craft'];
                $this->musical_skill = $skillAssessmentArray['musical_skill'];
            }
            // $this->age = $assessment->first()->skill_assessments;
        }
        // elseif($assessment->count() == 0) 
    }

    public function cancel() {
        // $this->
    }


    public function render()
    {
        return view('livewire.teacher.student-skill-assessment');
    }
}
