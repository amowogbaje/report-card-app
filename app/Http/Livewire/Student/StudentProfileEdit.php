<?php

namespace App\Http\Livewire\Student;

use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\User;

use Livewire\Component;

class StudentProfileEdit extends Component
{
    public $profileId, $student, $classlevels, $class_id, $firstname, $lastname,
    $othernames, $email,  $gender, $guardian_phone, $phone, $guardian_address, $category, $citizenship,
    $state_origin, $lga_origin, $dob;

    public function update() {
        $user = User::find($this->profileId);
        $student = Student::find($this->student->id);

            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->othernames = $this->othernames;
            $user->email = $this->email;
            $user->phone = $this->phone;
            // $user->gender = $this->gender;
            $user->address = $this->guardian_address;
            $user->lga_origin = $this->lga_origin;
            $user->state_origin = $this->state_origin;
            $user->citizenship = $this->citizenship;
            $user->dob = $this->dob;
            // if($this->dob =="null")
            $user->save();
            if($user) {
                $student->user_id = $user->id;
                $student->guardian_phone = $this->guardian_phone;
                $student->student_phone = $this->phone;
                $student->class_id = $this->class_id;
                $student->category = $this->category;
                // $student->guardian_name = $this->guardian_name;
                $student->guardian_address = $this->guardian_address;
                $student->save();
                $this->emit('toast:success', [
                    'text' => $this->firstname.' info has been Successfully edited',
                    // 'modalID' => "#add_student_modal"
                ]);
            }
    }
    public function mount() {
        $this->classlevels = ClassLevel::all();
        $this->student = Student::where('user_id', $this->profileId)->first();
        $this->class_id = $this->student->class_id;
        $this->firstname = $this->student->user->firstname;
        $this->lastname = $this->student->user->lastname;
        $this->othernames = $this->student->user->othernames;
        $this->email = $this->student->user->email;
        $this->gender = $this->student->user->gender;
        $this->guardian_phone = $this->student->guardian_phone;
        $this->phone = $this->student->user->phone;
        $this->guardian_address = $this->student->guardian_address;
        $this->category = $this->student->category;
        $this->citizenship = $this->student->user->citizenship;
        $this->state_origin = $this->student->user->state_origin;
        $this->lga_origin = $this->student->user->lga_origin;
        $this->dob = $this->student->user->dob;
    }

    public function render()
    {
        return view('livewire.student.student-profile-edit');
    }
}
