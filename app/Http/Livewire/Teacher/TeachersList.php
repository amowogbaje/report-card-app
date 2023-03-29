<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Teacher;
use App\Models\User;

use Auth;

use App\Exports\TeachersExport;
use App\Exports\TeachersTemplateExport;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\TeachersImport;

use Livewire\WithFileUploads;


class TeachersList extends Component
{
    use WithFileUploads;
    public $number;

    public $file, $firstname, $lastname, $email, $phone, $gender = 'male';

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string',
        // 'phone' => 'required|string',
    ];

    public function mount($number)
    {
        $this->number = $number;
    }

    public function resetFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->phone = '';
    }
    
    public function store(User $user, Teacher $teacher) {
        $this->validate();
        // try {
            
            // $this->dispatchBrowserEvent('teacher-added');
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->username = $this->phone;
            $user->gender = $this->gender;
            $user->role = "teacher";
            $user->school_info_id = Auth::user()->school_info_id;
            $user->password = bcrypt(strtolower($this->firstname));
            $user->save();
            if($user) {
                $teacher->user_id = $user->id;
                $teacher->save();
                $this->emit('toast:success', [
                    'text' => $this->firstname.' added to the Teacher List Successfully!!',
                    'modalID' => "#add_teacher_modal"
                ]);
                // session()->flash('success', $this->firstname.' added to the Teacher List Successfully!!');
            }
            else {
                $this->emit('toast:failure', [
                    'text' => "Something goes wrong while creating category!!",
                    'modalID' => "#add_teacher_modal"
                ]);
                
                // session()->flash('error','Something goes wrong while creating category!!');
            }
            // Set flash field
            
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
        $this->mount($this->number);
        $this->render();
    }

    public function download() {
        return Excel::download(new TeachersExport, 'teachers.xlsx');
    }
    public function downloadTemplate() {
        return Excel::download(new TeachersTemplateExport(), 'Teachers Template.xlsx');
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
        $data = Excel::import(new TeachersImport, $path);

        if($data) {
            $this->emit('toast:success', [
                'text' => 'Mass Upload Successful!!',
                'modalID' => "#upload_teacher_modal"
            ]);
        }
        else {
            $this->emit('toast:failure', [
                'text' => 'Something goes wrong while adding teacher!!',
                'modalID' => "#upload_teacher_modal"
            ]);
        }
        



        // $params['file'] = $fileName;
    }

    public function render()
    {
        return view('livewire.teacher.teachers-list', [
            'teachers' => Teacher::take($this->number)->get()
        ]);
    }
}
