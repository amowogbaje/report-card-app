<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\ClassStudent;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\SchoolInfo;
use App\Models\ClassStage;
use App\Models\Assessment;
use Auth;
use DB;

use App\Jobs\BootstrapStudents;
use App\Jobs\UndoStudentBootstrap;

use App\Exports\StudentExport;
use App\Exports\StudentTemplateExport;

use Maatwebsite\Excel\Facades\Excel;

// use App\Exports\UsersImport;
use App\Imports\StudentImport;

use Livewire\WithFileUploads;


class StudentList extends Component
{
    use WithFileUploads;
    public $number, $file, $class_teacher_id=null;

    public $firstname, $lastname, $class_stage_id, $class_id, $email, $phone, $othernames, $admission_no, $guardian_name, $classStageIsSecondary = false, $guardian_phone, $student_phone, $guardian_address,  $gender = 'male', $category;
    public $percentage, $studentDetails, $studentFullName, $principal_comment;


    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        // 'email' => 'required|email|unique:users',
        'email' => 'required|email',
        'class_id' => 'required|integer',
        'class_stage_id' => 'required|integer',
        'phone' => 'required|string',
        'gender' => 'required|string',
        'admission_no' => 'required|string',
        // 'guardian_phone' => 'required|string',
        'guardian_name' => 'required|string',
    ];

    public function resetFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->othernames = '';
        $this->email = '';
        $this->phone = '';
        $this->admission_no = '';
        $this->guardian_name = '';
        $this->guardian_phone = '';
        $this->guardian_address = '';
    }

    public function store(User $user, Student $student, ClassStudent $classStudent) {
        $this->validate();
        // try {
            
            $schoolInfo = school_info();
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->othernames = $this->othernames;
            $user->email = $this->email;
            // $user->phone = $this->phone;
            //$user->username = "not yet assigned";
            $user->school_info_id = $schoolInfo->id;
            $user->gender = strtolower($this->gender);
            $user->address = $this->guardian_address;
            $user->username = $this->admission_no;
            $user->role = "student";
            $user->password = bcrypt(strtolower($this->firstname));
            $user->save();
            $current_session_id = active_session()->id;
            $current_term_id = active_term()->id;
            if($user) {
                $student->user_id = $user->id;
                $student->guardian_phone = $this->phone;
                $student->class_code = ClassLevel::where('id', $this->class_id)->first()->code;
                $firstStudentCheck = Student::where('class_code', $student->class_code)->count();
                if($firstStudentCheck == 0) {
                    $StudentMatricNo = "001";
                }
                else {
                    $previousStudentMatricNo = Student::where('class_code', $student->class_code)
                                                ->latest('id')->first()->class_matric_no;
                    $currentStudentMatricNo = (int) $previousStudentMatricNo + 1;
                    $StudentMatricNo = sprintf("%03d", $currentStudentMatricNo);
                }
                
                $student->class_matric_no = $StudentMatricNo;
                $student->student_phone = $this->student_phone;
                if($this->class_teacher_id == null) {
                    $student->class_id = $this->class_id;
                }
                else {
                    $student->class_id = $this->class_teacher_id;
                }
                
                $student->guardian_name = $this->guardian_name;
                $student->guardian_address = $this->guardian_address;
                $student->class_stage_id = $this->class_stage_id;
                $student->category = $this->category;
                $student->save();
                if($student) {
                    BootstrapStudents::dispatch($student);
                }
                $this->emit('toast:success', [
                    'text' => $this->firstname.' added to the Student List Successfully!!',
                    'modalID' => "#add_student_modal"
                ]);
            }
            else {
                $this->emit('toast:failure', [
                    'text' => 'Something goes wrong while adding student!!',
                    'modalID' => "#add_student_modal"
                ]);
            }
            
            $this->cancel();
        // }
        // catch(\Exception $e){
        //     // Set Flash Message
        //    
        // }
        // $this->closeModal()
    }


    public function cancel() {
        $this->resetFields();
        $this->mount($this->number, $this->class_teacher_id);
        $this->render();
    }

    public function chooseClassStage() {
        $this->classlevels = ClassLevel::where('class_stage_id', $this->class_stage_id)->get();
        if(ClassStage::where('id',$this->class_stage_id)->count() > 0) {
            if(ClassStage::where('id',$this->class_stage_id)->first()->shortname == 'senior') {
                $this->classStageIsSecondary = true;
            }
            else {
                $this->classStageIsSecondary = false;
            }
        }
        
    }
    
    public function normalizeNames() {
        $students = Student::where('class_id', $this->class_teacher_id)->get();
        foreach ($students as $student) {
            if(strpos($student->user->lastname, " ") !== false) {
                DB::table('users')->where("id", $student->user->id)->update([
                    'firstname' => $this->correctNameArrangement($student->user->lastname)[1],
                    'lastname' => $this->correctNameArrangement($student->user->lastname)[0]
                ]);
            }
            DB::table('users')->where("id", $student->user->id)->update([
                    'password' => bcrypt(strtolower(trim($student->user->firstname)))
                ]);
            
        }
        $this->cancel();
        
    }
    
    public function comment($id) {
        $this->studentDetails = Student::where('id', $id)->first();
        $this->percentage = json_decode(html_entity_decode($this->studentDetails->assessment->academic_assessments), true)['percentage'];
        $this->studentFullName = $this->studentDetails->user->fullname;
        $this->principal_comment = $this->studentDetails->assessment->principal_comment;
    }
    
    public function storeComment() {
        $params = $this->validate(['principal_comment' => 'required|string']);
        $storeComment = Assessment::where('student_id', $this->studentDetails->id)->update(['principal_comment' => $this->principal_comment]);
        $this->emit('toast:success', [
                    'text' => 'Comment Added Successfully!!',
                    'modalID' => "#add_comment_modal"
                ]);
        $this->mount();
        $this->render();
        
    }
    
    
    public function correctNameArrangement($name) {
        $nameArray = explode(' ', $name);
        return $nameArray;
    }
    public function givepassword() {
        $students = Student::where('class_id', $this->class_teacher_id)->get();
        foreach ($students as $student) {
            DB::table('users')->where("id", $student->user->id)->update([
                'password' => bcrypt(trim($student->user->firstname))
            ]);
        }
    }


    public function mount($number, $class_teacher_id=null)
    {
        $this->number = $number;
        $this->class_teacher_id = $class_teacher_id;
        $this->gender = 'male';
        $this->classlevels = [];
        // $this->emit('reload');
    }
    
    
    

    public function downloadStudentList($class_id = null) {
        if($class_id == null) {
            return Excel::download(new StudentExport($class_id), 'All Students List.xlsx');
        }
        else {
            $class = ClassLevel::where('id', $class_id)->first();
            return Excel::download(new StudentExport($class_id), $class->name . " " . $class->alias . ' Students List.xlsx');
        }
        
    }
    public function downloadTemplate() {
        return Excel::download(new StudentTemplateExport(), 'Students Template.xlsx');
    }

    

    public function upload() {
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        $param = $this->validate([
            'file' => ['required','mimes:xlsx']
        ]);
        // $fileName = $this->file->store('document', 'public_uploads');
        $path = $this->file->getRealPath();
        $data = Excel::import(new StudentImport($this->class_teacher_id), $path);

        if($data) {
            $this->emit('toast:success', [
                'text' => 'Mass Upload Successful!!',
                'modalID' => "#upload_student_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => 'Something goes wrong while adding student!!',
                'modalID' => "#upload_student_modal"
            ]);
        }
        



        // $params['file'] = $fileName;
    }

    public function render()
    {
        $className = null;
        $classLevelObject = null;
        $class_teacher_id = $this->class_teacher_id;
        $schoolInfo = school_info();
        $class_stages = ClassStage::where('groupname', $schoolInfo->type)->get();
        if($this->class_teacher_id == null) {
            $students = Student::take($this->number)->orderBy('class_code', 'asc')->orderBy('class_id','asc')->get();
        }
        else {
            $classLevelObject = ClassLevel::where('id', $class_teacher_id)->first();
            $students = Student::where('class_id', $this->class_teacher_id)->take($this->number)->get();
        }
        
        $classlevels = $this->classlevels;
        $this->emit('reload');
        
        return view('livewire.student.student-list', compact('students', 'classlevels', 'class_teacher_id', 'classLevelObject', 'class_stages'));
    }

    public function delete($studentId) {
        $student = Student::find($studentId);
        $student->status = 0;
        $studentDeativated = $student->save();
        if($studentDeativated) {
            UndoStudentBootstrap::dispatch($student);
        }
        
        $this->cancel();
    }
    public function restore($studentId) {
        $student = Student::find($studentId);
        $student->status = 1;
        $student->save();
        $studentReativated = $student->save();
        if($studentReativated) {
            BootstrapStudents::dispatch($student);
        }
        $this->cancel();
    }
}
