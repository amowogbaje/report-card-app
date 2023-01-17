<?php

namespace App\Http\Livewire\Student;
// use Illuminate\Foundation\Validation\ValidatesRequests;
use Livewire\Component;
use App\Models\Student;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\PaymentDetails;
use App\Models\Transaction;
use Livewire\WithFileUploads;


// use Validator;

class StudentPayment extends Component
{
    // use ValidatesRequests;

    use WithFileUploads;

    protected $rules = [
        'amount' => 'required',
        'payment_method' => 'required',
    ];

    public $profileId, $student_account_name = null, 
            $payment_detail_id = null, $payment_method, 
            $amount, $user_id, $student_id, $showBankTransferForms = false;
    public $transaction_id, $proof, $image_url;


    public function mount() {}

    public function pay() {
        $this->emit('swal:notify', [
            'title' => 'Button Working',
            'text' => "....",
            // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        ]);
    }

    public function uploadProof() {
        $validatedData = $this->validate([
            'proof' => 'required|image',
        ]);

        $transaction = Transaction::find($this->transaction_id);
        $transaction->proof_url = $this->proof->store('proof_of_payment', 'public_uploads');
        if($transaction->save()) {
            $this->proof = "null";
        }
        $this->emit('swal:notify', [
            'title' => 'File Uploaded',
            'text' => "....",
        ]);
  
    }


    public function makePayment() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $student = Student::where('user_id', $this->profileId)->first();
        $transaction = new Transaction;
        $transaction->payment_detail_id = $this->payment_detail_id;
        $transaction->student_account_name = $this->student_account_name;
        $transaction->amount = $this->amount;
        $transaction->student_id = $student->id;
        // $transaction->user_id = $student->user_id;
        $transaction->payment_method = $this->payment_method;
        $transaction->session_id = $current_session_id;
        $transaction->term_id = $current_term_id;
        $transaction->status = 'pending';
        $transaction->ref_no = (FLOOR(RAND() * 401) + 100);
        $transaction->save();

        // $this->cancel();
        
    }

    public function choose() {
        $this->validate();
        // dd($this);
        if($this->payment_method == 'deposit_by_hand') {
            $this->validate([
                'amount' => 'required',
                'payment_method' => 'required',
            ]);
            
            $this->makePayment();
            $this->emit('swal:notify', [
                'title' => 'Transaction Saved',
                'text' => "This transaction will be approved when you pay in cash to the bursar office",
                'icon' => 'info',
                // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
            ]);
        }
        elseif($this->payment_method == 'bank_transfer') {
            $this->validate([
                'amount' => 'required',
                'payment_detail_id' => 'required',
                'payment_method' => 'required',
                'student_account_name' => 'required',
            ]);
            $this->makePayment();
            $this->emit('swal:notify', [
                'title' => 'Transaction Saved',
                'text' => "Kindly complete your transfer and upload your transaction snapshot with the upload button on your transaction",
                'icon' => 'info',
                // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
            ]);
        }
        elseif($this->payment_method == 'atm') {
            $this->validate([
                'amount' => 'required',
                'payment_detail_id' => 'required',
                'payment_method' => 'required',
                'student_account_name' => 'required',
            ]);
            $this->makePayment();
            $this->emit('swal:notify', [
                'title' => 'Kindly Proceed to the next phase of payment so that we can approve your payment on confirmation',
                'text' => "",
                'icon' => 'info',
                // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
            ]);
        }
        $this->cancel();
        

        // else {
        //     $this->emit('swal:notify', [
        //         'title' => 'Let us Proceed',
        //         'text' => "",
        //         'icon' => 'info',
        //         // 'footer' => '<a href='.route('student.payment-index').'>Click here to make payment</a>'
        //     ]);
        // }
    }
    public function paymentOption() {
        if($this->payment_method == 'bank_transfer' || $this->payment_method == 'atm') {
            $this->showBankTransferForms = true;
        }
        if($this->payment_method == 'deposit_by_hand') {
            $this->showBankTransferForms = false;
        }

    }

    public function resetFields() {
        $this->student_account_name = null;
        $this->payment_detail_id = null;
        $this->payment_method = "";
        $this->amount = ""; 
        $this->user_id = ""; 
        $this->student_id = "";
        $this->showBankTransferForms = false;
    }

    public function cancel() {
        $this->resetFields();
        $this->mount();
        $this->render();
    }


    public function render()
    {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $student = Student::where('user_id', $this->profileId)->first();
        $paymentDetails = PaymentDetails::all();
        $depositByHandTransactions = Transaction::where('student_id', $student->id)
                                    ->where('payment_method', 'deposit_by_hand')
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->take(15)->orderBy('created_at', 'desc')
                                    ->get();
        $bankTransferTransactions = Transaction::where('student_id', $student->id)
                                    ->where('payment_method', 'bank_transfer')
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->take(15)->orderBy('created_at', 'desc')
                                    ->get();
        $atmTransactions = Transaction::where('student_id', $student->id)
                                    ->where('payment_method', 'atm')
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->take(15)->orderBy('created_at', 'desc')
                                    ->get();
        $approvedTransactions = Transaction::where('student_id', $student->id)
                                        ->where('status', 'approved')
                                        ->where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id)
                                        ->get();
        $showBankTransferForms = $this->showBankTransferForms;
        return view('livewire.student.student-payment', compact('student', 
                'paymentDetails', 'showBankTransferForms', 
                'depositByHandTransactions','bankTransferTransactions','atmTransactions', 
                'approvedTransactions'));
    }
}

// TODOs
// Work on upload receipt and the rest of image uploads
// Work on admin approval
