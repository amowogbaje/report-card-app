<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassLevel;
use App\Models\ClassStage;
use App\Models\TeacherSubjectClass;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\SchoolInfo;

use Auth;
use DB;

class Subjects extends Component
{
    public $number, $name, $subject_id, $teacher_id, $class_id, 
            $class_stage_id, $category, $classlevels, $periods,
            $classStageIsSecondary = false, $update = false,
            $listOfSubjects;

    // protected $listeners = ['setCategory', 'setClass_stage_id'];

    protected $rules = [
        'name' => 'required|string',
        'class_stage_id' => 'required',
    ];

    public function mount($number) {
        $this->number = $number;
        $this->classlevels = ClassLevel::all();
        $this->listOfSubjects = "English Language, Mathematics, Biology, Economics, Civics";
    }

    // public function setClass_stage_id($value) 
    // {
    //     $this->syncInput('class_stage_id', $value);
    // }

    // public function updatedClass_stage_id() {
    //     if($this->class_stage_id == 6) {
    //         $this->listOfSubjects = "English Language, Mathematics, Basic Science, Basic Technology";
    //     }
    //     elseif($this->class_stage_id == 7) {
    //         $this->listOfSubjects = "English Language, Mathematics, Biology, Economics, Civics";
    //     }
    // }

    // public function setCategory($value) 
    // {
    //     $this->syncInput('category', $value);
    // }

    public function updatedCategory() {
        if($this->category == "science") {
            $this->listOfSubjects = "Chemistry, Physics, Geography, Furthermatics, Technical Drawing";
        }
        elseif($this->category == "art") {
            $this->listOfSubjects = "Literature In English, Government, Yoruba";
        }
    }

    public function add_subject() {
        $this->validate([
            'name' => 'required|string',
            'class_stage_id' => 'required'
        ]);
        $subject = new Subject;
        $subject->name = $this->name;
        $subject->class_stage_id = $this->class_stage_id;
        $subject->category = $this->category;
        $subject->save();
        $this->emit('toast:success', [
            'text' => "Subject Added!",
            'modalID' => "#add_subject_modal"
        ]);
        $this->cancel();
        // session()->flash('success',"Subject Added!");
        // return redirect('/dashboard');
    }

    public function addManySubjects() {
        $this->validate([
            'listOfSubjects' => 'required|string',
            'class_stage_id' => 'required'
        ]);

        $listOfSubjects = $this->listOfSubjects;
        $subjectArray = explode(",", $listOfSubjects);
        foreach ($subjectArray as $subjectName) {
            $subjectExist = DB::table('subjects')
                            ->where('name', $subjectName)
                            ->where('class_stage_id', $this->class_stage_id)
                            ->where('category', $this->category)
                            ->count();
            if($subjectExist == 0) {
                DB::table('subjects')->insert([
                    'name' => $subjectName,
                    'class_stage_id' => $this->class_stage_id,
                    'category' => $this->category,
                ]);
                $this->emit('toast:success', [
                    'text' => "$subjectName successfully Added!",
                    'modalID' => "#add_many_subject_modal"
                ]);
            }
            else {
                $this->emit('toast:failure', [
                    'text' => "$subjectName has already been Added!",
                    'modalID' => "#add_many_subject_modal"
                ]);
            }
            
        }
        
        $this->cancel();
    }

    public function assignTeachers() {
        $this->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'periods' => 'required'
        ]);
        // $teacherSubjectClass = new TeacherSubjectClass;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $noOfPeriodsTeacherHad = TeacherSubjectClass::where('term_id', $current_term_id)
                                        ->where('session_id', $current_session_id)
                                        ->where('teacher_id', $this->teacher_id)
                                        ->sum('periods');
        $noOfPeriodsTeacherWillHave = $noOfPeriodsTeacherHad + $this->periods;
        if($noOfPeriodsTeacherWillHave > 22) {
            $this->emit('swal:notify', [
                'title' => "Number of Periods too much for Teacher",
                'text' => "Kindly reshuffle and reassign"
                ]);
        }
        else {
            $teacherSubjectClass = TeacherSubjectClass::where('class_id', $this->class_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('session_id', $current_session_id)
                                            ->where('subject_id', $this->subject_id);

            if($teacherSubjectClass->count() == 0) {
                $teacherSubjectClass = new TeacherSubjectClass;
                $teacherSubjectClass->teacher_id = $this->teacher_id;
                $teacherSubjectClass->class_id = $this->class_id;
                $teacherSubjectClass->term_id = $current_term_id;
                $teacherSubjectClass->session_id = $current_session_id;
                $teacherSubjectClass->subject_id = $this->subject_id;
                $teacherSubjectClass->periods = $this->periods;
                $teacherSubjectClass->save();
                session()->flash('success',"Teacher has been Assigned to Subject!");
                $this->emit('toast:success', [
                    'text' => "Teacher has been Assigned to Subject!". $noOfPeriodsTeacherWillHave,
                    'modalID' => "#assign_teacher_to_subject_modal"
                ]);
            }
            else {
                $teacherSubjectClass->update(['teacher_id' => $this->teacher_id, 'periods' => $this->periods]);
                // session()->flash('success',"Subject Teacher Updated!");
                $this->emit('toast:success', [
                    'text' => "Subject Teacher Updated!",
                    'modalID' => "#assign_teacher_to_subject_modal"
                ]);
            }

        }
        

        // return redirect('/dashboard');
        $this->cancel();

    }

    public function add() {
        $this->update = false;
        $this->name = '';
        $this->class_stage_id = '';
        $this->category = '';
    }
    public function edit($id) {
        $this->update = true;
        $subject = Subject::where('id', $id)->first();
        $this->name = $subject->name;
        $this->class_stage_id = $subject->class_stage_id;
        $this->category = $subject->category;
    }

    public function update_subject() {
        $subject = Subject::find($this->subject_id);
        $subject->name = $this->name;
        $subject->class_stage_id = $this->class_stage_id;
        $subject->category = $this->category;
        $subject->save();
        $this->emit('toast:success', [
            'text' => "Subject Updated!",
            'modalID' => "#add_subject_modal"
        ]);
        $this->cancel();
    }

    public function resetFields() {
        $this->name = '';
        $this->class_id = '';
        $this->subject_id = '';
    }
    public function cancel() {
        $this->update = false;
        $this->resetFields();
        $this->mount($this->number);
        $this->render();
    }

    public function selectSubject() {
        $classStageId = Subject::where('id',$this->subject_id)->first()->class_stage_id;
        $this->classlevels = ClassLevel::where('class_stage_id', $classStageId)->get();

    }

    public function chooseClassStage() {
        if(ClassStage::where('id',$this->class_stage_id)->count() > 0) {
            if(ClassStage::where('id',$this->class_stage_id)->first()->shortname == 'senior') {
                $this->classStageIsSecondary = true;
            }
            else {
                $this->classStageIsSecondary = false;
            }
        }
        
    }

    public function render()
    {
        $teachers = Teacher::all();
        $classlevels = $this->classlevels;
        $schoolInfo = SchoolInfo::where('id', Auth::user()->school_info_id)->first();
        $class_stages = ClassStage::where('groupname', $schoolInfo->type)->get();
        $subjects = Subject::take($this->number)->orderBy('id', 'asc')->get();
        return view('livewire.subjects', compact('subjects', 'teachers', 'classlevels', 'class_stages'));
    }
}
