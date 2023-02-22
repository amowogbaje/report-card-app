<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

use App\Models\Student;
use App\Models\User;
use App\Models\PaymentCode;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class StudentProfile extends Component
{
    use WithFileUploads;
    public $profileId, $student, $pics, $payment_verification_code;


    public function report() {
        $this->emit('swal:notify', [
            'title' => 'Payment not Complete',
            'text' => "Kindly complete your payment to view your academic report or see the bursar to confirm your payment",
            'icon' => 'error',
            // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        ]);
    }

    public function verifyPayment(){
        $this->payment_verification_code;
        $payVerification = PaymentCode::where('payment_verification_code', $this->payment_verification_code);
        if($payVerification->count() != 0) {
            if(!$payVerification->first()->used) {
                if($payVerification->first()->student_id == $this->student->id) {
                    $paymentVerification = PaymentCode::find($payVerification->first()->id);
                    $paymentVerification->used = 1;
                    $paymentVerification->save();

                    $student = Student::find($this->student->id);
                    $student->payment_complete = 1;
                    $student->save();


                    $this->emit('toast:success', [
                        'text' => "Your Payment has now been confirmed",
                        'modalID' => "#enter_acess_code_modal"
                    ]);
                }
                else {
                    $this->emit('swal:notify', [
                        'title' => 'Wrong Access Code',
                        // 'text' => "Kindly complete your payment to view your academic report or see the bursar to confirm your payment",
                        'icon' => 'error',
                        // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
                    ]);
                }
                

            }
            else {
                $this->emit('swal:notify', [
                    'title' => 'Access Code does not exist or has been used',
                    // 'text' => "Kindly complete your payment to view your academic report or see the bursar to confirm your payment",
                    'icon' => 'error',
                    // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
                ]);
            }
            
        }
        else {
            $this->emit('swal:notify', [
                'title' => 'Access Code does not exist or has been used',
                // 'text' => "Kindly complete your payment to view your academic report or see the bursar to confirm your payment",
                'icon' => 'error',
                // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
            ]);
        }
        $this->refreshComponent();

    }

    public function refreshPage() {
        $this->mount();
        $this->render();
    }
    public function uploadPics() {
        // $param = $this->validate([
        //     'pics' => 'image|mimes:png,jpg|max:102400'
        // ]);
        sleep(3);
        // $user = User::where('id',$this->profileId)->first();
        $updateUserInfo = User::find($this->profileId);
        $oldfile = $user->profile_pics;
        $fileName = $this->pics->store('profile-pics/students', 'public_uploads');
        $updateUserInfo->profile_pics = $fileName;
        $updateUserInfo->save();
        // unlink($oldfile);
        // Storage::disk('public_uploads')->delete($oldfile);
        $this->emit('toast:success', [
            'text' => "Your Profile has been updated: ",
            'modalID' => "#behaviour_assessment_modal"
        ]);
        $this->refreshComponent();
    }
    // public function checkIfPhysicalAssessment

    public function mount() {
        $this->student = Student::where('user_id', $this->profileId)->first();
    }
    public function render()
    {
        

        return view('livewire.student.student-profile');
    }
}
