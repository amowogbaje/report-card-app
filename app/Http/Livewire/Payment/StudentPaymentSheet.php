<?php

namespace App\Http\Livewire\Payment;

use Livewire\Component;

use App\Models\Student;
use App\Models\ClassLevel;

class StudentPaymentSheet extends Component
{
    public $classlevels, $classes = [], $allStudents = [], $classStudents;

    public function mount() {
        // $this->allStudents = Student::all();
        $classlevels = ClassLevel::all();
        foreach($classlevels as $classlevel) {
            $this->classes["$classlevel->shortname $classlevel->alias"] = $classlevel->name. " ". $classlevel->alias;
            $this->allStudents["$classlevel->shortname $classlevel->alias"] = Student::where('class_id', $classlevel->id)
                                                                                    ->where('status', 1)->get();
        }
        // $this->allStudents = json_encode($this->allStudents);
    }

    public function confirmPayment($studentId) {
        $student = Student::find($studentId);
        $student->payment_complete = 1;
        $student->save();
        $this->emit('toast:success', [
            'text' => $student->user->firstname." ".$student->user->lastname." payment status confirmed",
            // 'modalID' => "#add_paymsent_detail_modal"
        ]);
        $this->mount();
        $this->render();
    }

    public function unconfirmPayment($studentId) {
        $student = Student::find($studentId);
        $student->payment_complete = 0;
        $student->save();
        $this->emit('toast:failure', [
            'text' => $student->user->firstname." ".$student->user->lastname." payment status unconfirmed",
            // 'modalID' => "#add_payment_detail_modal"
        ]);
        $this->mount();
        $this->render();
    }
    public function render()
    {
        return view('livewire.payment.student-payment-sheet');
    }
}