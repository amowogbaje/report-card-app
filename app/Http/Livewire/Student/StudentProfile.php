<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\Student;

class StudentProfile extends Component
{
    public $profileId;

    public function report() {
        $this->emit('swal:notify', [
            'title' => 'Payment not Complete',
            'text' => "Kindly complete your payment to view your academic report or see the bursar to confirm your payment",
            'icon' => 'error',
            // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        ]);
    }
    public function render()
    {
        $student = Student::where('user_id', $this->profileId)->first();

        return view('livewire.student.student-profile', ['student' => $student]);
    }
}
