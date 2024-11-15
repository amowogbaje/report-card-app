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
use App\Models\SubjectTerm;
use App\Models\SchoolInfo;

use Auth;
use DB;

class Subjects extends Component
{
    public $number, $name, $subject_id, $teacher_id, $class_id, 
            $class_stage_id, $category="", $classlevels, $periods,
            $classStageIsSecondary = false, $update = false, $isAssigned = false,
            $listOfSubjects, $noOfJuniorSubjects, $noOfSeniorSubjects;

    // protected $listeners = ['setCategory', 'setClass_stage_id'];

    protected $rules = [
        'name' => 'required|string',
        'class_stage_id' => 'required',
    ];

    public function mount($number) {
        
        $this->noOfJuniorSubjects = SubjectTerm::where('class_stage_id', 6)
                                    ->where('session_id', active_session()->id)
                                    ->where('term_id', active_term()->id)
                                    ->count();
        $this->noOfSeniorSubjects = SubjectTerm::where('class_stage_id', 7)
                                    ->where('session_id', active_session()->id)
                                    ->where('term_id', active_term()->id)
                                    ->count();
        $this->number = $number;
        $this->classlevels = ClassLevel::orderBy('code')->get();
        $this->listOfSubjects = "English Language, Mathematics, Biology, Economics, Civics";
        // $this->emit('reload');
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
        $subjectExist = DB::table('subjects')
                            ->where('name', trim($this->name))
                            ->where('class_stage_id', $this->class_stage_id)
                            ->where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->count();
        if($subjectExist == 0) {
            $subject = new Subject;
            $subject->name = trim($this->name);
            $subject->class_stage_id = $this->class_stage_id;
            $subject->category = $this->category;
            $subject->session_id = active_session()->id;
            $subject->term_id = active_term()->id;
            $subject->save();
            $this->emit('toast:success', [
                'text' => "Subject Added!",
                'modalID' => "#add_subject_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "$this->name has already been Added!",
                'modalID' => "#add_many_subject_modal"
            ]);
        }
        $this->cancel();
        // session()->flash('success',"Subject Added!");
        // return redirect('/dashboard');
    }
    public function add_subject_to_list() {
        $this->validate([
            'subject_id' => 'required',
        ]);
        $subjectExist = DB::table('subject_terms')
                            ->where('subject_id', trim($this->subject_id))
                            ->where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->count();
        $subject = Subject::where('id', $this->subject_id)->first();
        if($subjectExist == 0) {
            $subjectTerm = new SubjectTerm;
            $subjectTerm->class_stage_id = $subject->class_stage_id;
            $subjectTerm->subject_id = $this->subject_id;
            $subjectTerm->session_id = active_session()->id;
            $subjectTerm->term_id = active_term()->id;
            $subjectTerm->save();
            $this->emit('toast:success', [
                'text' => "Subject Added for the term!",
                'modalID' => "#add_subject_term_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => "$subject->name has already been Added for the term!",
                'modalID' => "#add_subject_term_modal"
            ]);
        }
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
                            ->where('name', trim($subjectName))
                            ->where('class_stage_id', $this->class_stage_id)
                            ->where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->count();
            if($subjectExist == 0) {
                DB::table('subjects')->insert([
                    'name' => trim($subjectName),
                    'class_stage_id' => $this->class_stage_id,
                    'category' => $this->category,
                    'session_id' => active_session()->id,
                    'term_id' => active_term()->id
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
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
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
                $teacherSubjectClass->class_code = $class_code;
                $teacherSubjectClass->term_id = $current_term_id;
                $teacherSubjectClass->session_id = $current_session_id;
                $teacherSubjectClass->subject_id = $this->subject_id;
                $teacherSubjectClass->periods = $this->periods;
                $teacherSubjectClass->save();
                session()->flash('success',"Teacher has been Assigned to Subject!");
                $this->emit('toast:success', [
                    'text' => "Teacher has been Assigned to Subject!",
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
        $this->class_id = '';
        $this->mount($this->number);
        $this->render();

    }

    public function hasAssigned() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacherSubjectClassCount = TeacherSubjectClass::where('class_id', $this->class_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('session_id', $current_session_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->count();
        if($teacherSubjectClassCount == 0) {
            $this->isAssigned = false;
        }
        else {
            $this->isAssigned = true;
        }
    }

    public function add() {
        $this->update = false;
        $this->name = '';
        $this->class_stage_id = '';
        // $this->category = '';
    }
    public function edit($id) {
        $this->update = true;
        $this->subject_id = $id;
        
        
        $subject = Subject::where('id', $id)->first();
        $this->chooseClassStageWithParameter($subject->class_stage_id);
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
        $this->classlevels = ClassLevel::where('class_stage_id', $classStageId)->orderBy('code')->get();

    }

    public function delete($id) {
        $subject = Subject::find($id);
        $subject->delete();
        $this->emit('toast:success', [
            'text' => "Subject Deleted!",
            'modalID' => "#add_subject_modal"
        ]);
        $this->cancel();
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
    
    public function chooseClassStageWithParameter($stage) {
        if(ClassStage::where('id',$stage)->count() > 0) {
            if(ClassStage::where('id',$stage)->first()->shortname == 'senior') {
                $this->classStageIsSecondary = true;
            }
            else {
                $this->classStageIsSecondary = false;
            }
        }
        
    }

    public function render()
    {
        
        $teachers = Teacher::where('status', 1)->get();
        $classlevels = $this->classlevels;
        $schoolInfo = SchoolInfo::where('id', Auth::user()->school_info_id)->first();
        $class_stages = ClassStage::where('groupname', $schoolInfo->type)->get();
        $subjects = Subject::orderBy('name', 'asc')->get();
        $subject_for_term = SubjectTerm::where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->orderBy('id', 'asc')
                            ->get();
        $this->emit('reload');
        return view('livewire.subjects', compact('subjects', 'teachers', 'classlevels', 'class_stages', 'subject_for_term'));
    }
}
