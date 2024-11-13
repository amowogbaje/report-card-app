<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ClassLevel;
use App\Models\ClassTeacher;
use App\Models\ClassStage;
use App\Models\Teacher;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\SchoolInfo;
use App\Models\ClassAssessment;

use Auth;

class Classlevels extends Component
{
    public $name, $code, $shortname, $alias, $school_fee, $teacher_id, $class_id, $class_stage_id, $update = false;
    public $buttonText = "Save Changes";

    protected $rules = [
        'name' => 'required|string',
        'shortname' => 'required|string',
        // 'alias' => 'required',
        'class_stage_id' => 'required',
        // 'school_fee' => 'required',
    ];

    public function assignTeachers() {
        $this->validate(['teacher_id' => 'required']);
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;

        $classTeacher = ClassTeacher::where('class_id', $this->class_id)
                                        ->where('term_id', $current_term_id)
                                        ->where('session_id', $current_session_id);
        $alreadyAssignedTeacher = ClassTeacher::where('teacher_id', $this->teacher_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('session_id', $current_session_id)
                                            ->count();
        if($alreadyAssignedTeacher != 0){
            $this->emit('toast:failure', [
                'text' => "You can't assign a teacher to more than ONE class!",
                'modalID' => "#assign_teacher_to_class_modal"
            ]);
        }
        elseif($classTeacher->count() == 0) {
            $classTeacher = new ClassTeacher;
            $classTeacher->teacher_id = $this->teacher_id;
            $classTeacher->class_id = $this->class_id;
            $classTeacher->term_id = $current_term_id;
            $classTeacher->session_id = $current_session_id;
            $classTeacher->save();
            // session()->flash('success',"Teacher has been Assigned to class!");
            $this->emit('toast:success', [
                'text' => "Teacher has been Assigned to class!",
                'modalID' => "#assign_teacher_to_class_modal"
            ]);
        }
        else {
            $classTeacher->update(['teacher_id' => $this->teacher_id]);
            // session()->flash('success',"Class Teacher Updated!");
            $this->emit('toast:success', [
                'text' => "Class Teacher Updated!",
                'modalID' => "#assign_teacher_to_class_modal"
            ]);
        }
        $this->cancel();

        // return redirect('/dashboard');
    }

    public function add_class() {
        $this->validate();
        $class = new ClassLevel;
        $class->name = $this->name;
        $class->shortname = $this->shortname;
        $class->alias = $this->alias;
        $class->code = $this->code;
        $class->class_stage_id = $this->class_stage_id;
        $schoolInfo = school_info();
        $class->type = $schoolInfo->type;
        
        // $class->school_fee = $this->school_fee;
        $class->save();
        
        if($class) {
            ClassAssessment::insert([
                'highest_score' => 0,
                'lowest_score' => 0,
                'average_score' => 0,
                'session_id' => active_session()->id,
                'term_id' => active_term()->id,
                'class_id' => $class->id
            ]);
        }
        
        $this->emit('toast:success', [
            'text' => "Class Added!",
            'modalID' => "#add_class_modal"
        ]);
        $this->cancel();
        // session()->flash('success',"Class Added!");
        // return redirect('/dashboard');
    }

    public function add() {
        $this->update = false;
        $this->name = '';
        $this->shortname = '';
        $this->alias = '';
        $this->class_id = '';
        $this->class_stage_id = '';
    }
    public function edit($id) {
        $this->update = true;
        $class = ClassLevel::where('id', $id)->first();
        $this->name = $class->name;
        $this->shortname = $class->shortname;
        $this->alias = $class->alias;
        $this->class_stage_id = $class->class_stage_id;
        // $this->school_fee = $class->school_fee;
        $this->code = $class->code;
        $this->class_id = $class->id;
        $this->buttonText = "Update Class";
    }

    public function update_class() {
        $class = ClassLevel::find($this->class_id);
        $class->name = $this->name;
        $class->shortname = $this->shortname;
        $class->alias = $this->alias;
        $class->class_stage_id = $this->class_stage_id;
        $class->code = $this->code;
        // $class->school_fee = $this->school_fee;
        $class->save();
        // session()->flash('success',"Class Updated!");
        $this->emit('toast:success', [
            'text' => "Class Updated!",
            'modalID' => "#add_class_modal"
        ]);
        $this->cancel();
    }
    
    public function cancel() {
        $this->update = false;
        $this->resetFields();
        $this->mount();
        $this->render();
    }

    public function resetFields() {
        $this->name = '';
        $this->shortname = '';
        $this->alias = '';
        $this->class_id = '';
        $this->class_stage_id = '';
    }


    public function mount() {

    }
    public function render()
    {
        $teachers = Teacher::all();
        $schoolInfo = school_info();
        $classlevels = ClassLevel::where('type', trim($schoolInfo->type))->orderBy('code')->get();
        $class_stages = ClassStage::where('groupname', trim($schoolInfo->type))->get();
        $this->emit('reload');
        return view('livewire.classlevels', compact('classlevels', 'teachers', 'class_stages'));
    }
}
