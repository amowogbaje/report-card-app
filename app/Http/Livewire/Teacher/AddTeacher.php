<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\User;
use App\Models\Teacher;

class AddTeacher extends Component
{

    public $firstname, $lastname, $email, $phone, $gender = 'male';

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        // 'phone' => 'required|string',
    ];

    public function mount() {
        // $this->$sessionYear = $sessionYear;
    }

    public function resetFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->phone = '';
    }

    public function closeModal() {

    }

    public function store(User $user, Teacher $teacher) {
        $this->validate();
        // try {
            
            // $this->dispatchBrowserEvent('teacher-added');
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->gender = $this->gender;
            $user->role = "teacher";
            $user->password = bcrypt($this->firstname);
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
        $this->mount();
        $this->render();
    }

    public function render()
    {
        return view('livewire.teacher.add-teacher');
    }
}
