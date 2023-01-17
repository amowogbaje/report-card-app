<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\ClassStudent;

class AddStudent extends Component
{
    public $firstname, $lastname, $class_id = 1, $email, $phone, $guardian_name, $guardian_phone, $guardian_address, $gender = 'male';

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email',
        // 'class_id' => 'required|integer',
        'guardian_phone' => 'required|string',
        'guardian_name' => 'required|string',
    ];

    public function mount() {}

    public function resetFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->phone = '';
        $this->guardian_name = '';
        $this->guardian_phone = '';
        $this->guardian_address = '';
    }

    public function store(User $user, Student $student, ClassStudent $classStudent) {
        $current_session_id = SessionYear::where('active', true)->first()->id;
        $current_term_id = Term::where('active', true)->first()->id;
        $this->validate();
        // try {
            
            // $this->dispatchBrowserEvent('teacher-added');
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->gender = $this->gender;
            $user->address = $this->guardian_address;
            $user->role = "student";
            $user->password = bcrypt($this->firstname);
            $user->save();
            if($user) {
                $student->user_id = $user->id;
                $student->guardian_phone = $this->guardian_phone;
                $student->class_id = $this->class_id;
                $student->guardian_name = $this->guardian_name;
                $student->guardian_address = $this->guardian_address;
                $student->save();
                if($student) {
                    $classStudent->student_id = $student->id;
                    $classStudent->class_id = $student->class_id;
                    $classStudent->session_id = $current_session_id;
                    $classStudent->term_id = $current_term_id;
                    $classStudent->save();
                }
                

                $this->emit('toast:success', [
                    'text' => $this->firstname.' added to the Student List Successfully!!',
                    'modalID' => "#add_student_modal"
                ]);
                // session()->flash('success', $this->firstname.' added to the Student List Successfully!!');
            }
            else {
                $this->emit('toast:failure', [
                    'text' => 'Something goes wrong while adding student!!',
                    'modalID' => "#add_student_modal"
                ]);
                // session()->flash('error','Something goes wrong while creating category!!');
                // $this->resetFields();
            }
            // Set flash field
            
            // return redirect('/dashboard');
            // $this->resetFields();
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
        $this->mount();
        $this->render();
    }


    public function render()
    {
        return view('livewire.student.add-student', [
            'classlevels' => ClassLevel::all()
        ]);
    }
}
