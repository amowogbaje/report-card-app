<?php

namespace App\Http\Livewire;

use App\Models\Assessment;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\PromotionList;
use App\Models\TeacherSubjectClass;
use Auth;

use Livewire\Component;

class PrincipalComments extends Component
{
    public $student_id, $principal_comment, $principal_id, $class_id, $classlevels, $promotionStudentClassBranch, $promoted = 0,  $class_code;
    public $classCodeEnums = ['001' => 'JSS1', '002'=> 'JSS2', '003'=> 'JSS3', '004' => 'SSS1', '005'=> 'SSS2', '006'=> 'SSS3'];
    protected $rules = [
        'principal_comment' => 'required|string',
    ];

    public function mount() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $student = Student::where('id',$this->student_id)->first();
        $studentClassCode = $student->class_code;
        $promotionStudentClassCode = sprintf("%03d", ($studentClassCode+1));
        $this->class_code = $promotionStudentClassCode;
        $this->principal_id = Auth::user()->id;
        $classShortName = $student->class->shortname;
        $classBranchLetter = $classShortName[strlen($classShortName)-1];
        if(trim($classBranchLetter) == "E") {
            $classBranchLetter = 'D';
        }
        $classBranch = "%".$classBranchLetter;
        $promotionListCount = PromotionList::where('session_id', ($current_session_id+1))
                                ->where('term_id', 1)
                                ->where('student_id', $this->student_id)
                                // ->where('class_id', $this->class_id)
                                ->count();
        // $this->promoted = $promotionListCount;
        if($promotionListCount > 0) { $this->promoted = 1; } else { $this->promoted = 0;}
         
        // $this->classlevels = ClassLevel::where('code', $promotionStudentClassCode)->get();
        
        $this->promotionStudentClassBranch = ClassLevel::where('code', $promotionStudentClassCode)->first();
        // $this->classlevels = ClassLevel::where('id', '>' $student->class_id);
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
            $newAssessment->class_id = Student::where('id', $this->student_id)->first()->class_id;
            $newAssessment->school_info_id = Auth::user()->school_info_id;
            $newAssessment->principal_comment = $this->principal_comment;
            $newAssessment->principal_id = $this->principal_id;
            $newAssessment->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Your Comment has been saved",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        elseif($assessment->count() > 0) {
            $assessment->update(['principal_comment' => $this->principal_comment, 'principal_id' => $this->principal_id]);
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
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        
        $promotionList = PromotionList::where('session_id', ($current_session_id+1))
                                ->where('term_id', 1)
                                ->where('student_id', $this->student_id);
                                // ->where('class_id', $this->class_id);
        
        if($promotionList->count() == 0) {
            $newPromotion = new PromotionList;
            $newPromotion->session_id = ($current_session_id+1);
            $newPromotion->term_id = 1;
            $newPromotion->student_id = $this->student_id;
            $newPromotion->class_id = $this->class_id;
            $newPromotion->class_code = $this->class_code;
            $newPromotion->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Student has been added to Promotion List",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "There has been an error contact the developer",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        $this->mount();
        $this->render();
        
        
    }
    public function depromote() {
        
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        
        $promotionList = PromotionList::where('session_id', ($current_session_id+1))
                                ->where('term_id', 1)
                                ->where('student_id', $this->student_id);
                                // ->where('class_id', $this->class_id);
        
        if($promotionList->count() > 0) {
            
            $promotionList->delete();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Student has been removed from Promotion List",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "There has been an error contact the developer",
                'modalID' => "#behaviour_assessment_modal"
            ]);
        }
        $this->mount();
        $this->render();
        
        
    }

    public function makeAllocations() {
        $allPeriods = TeacherSubjectClass::where('term_id', $current_term_id)
                            ->where('session_id', $current_session_id)
                            ->get();
        $maxPeriod = TeacherSubjectClass::where('term_id', $current_term_id)
                                    ->where('session_id', $current_session_id)
                                    ->max('periods');
        $minPeriod = 1;
        $allocationArray = [];
        // while($minPeriod <= $maxPeriod) {
        //     $name = "group".$minPeriod;
        //     $allocationArray["$name"] = [];
        //     // $allocationArray["$name"] = [];
        // }

        foreach ($allPeriods as $key => $periods) {
            # code...
        }

    }

    public function render()
    {
        return view('livewire.principal-comments');
    }
}
