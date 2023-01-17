<?php

namespace App\Http\Livewire\Payment;

use App\Models\PaymentDetails as BankPaymentDetails;


use Livewire\Component;

class PaymentDetails extends Component
{
    public $bank_name, $account_name, $account_number, $payment_detail_id, $update = false;
    public $buttonText = "Save Changes";

    protected $rules = [
        'bank_name' => 'required|string',
        'account_name' => 'required|string',
        'account_number' => 'required',
    ];
    
    public function add() {
        $this->update = false;
        $this->bank_name = '';
        $this->account_name = '';
        $this->account_number = '';
    }
    public function edit($id) {
        $this->update = true;
        $this->payment_detail_id = $id;
        $paymentDetail = BankPaymentDetails::where('id', $id)->first();
        $this->bank_name = $paymentDetail->bank_name;
        $this->account_name = $paymentDetail->account_name;
        $this->account_number = $paymentDetail->account_number;
        $this->buttonText = "Update Class";
    }

    public function add_payment_detail() {
        $this->validate();
        $paymentDetail = new BankPaymentDetails;
        $paymentDetail->bank_name = $this->bank_name;
        $paymentDetail->account_name = $this->account_name;
        $paymentDetail->account_number = $this->account_number;
        $paymentDetail->save();
        $this->emit('toast:success', [
            'text' => "Payment Detail Added!",
            'modalID' => "#add_payment_detail_modal"
        ]);
        $this->cancel();
        // session()->flash('success',"Class Added!");
        // return redirect('/dashboard');
    }

    public function update_payment_detail() {
        $paymentDetail = BankPaymentDetails::find($this->payment_detail_id);
        $paymentDetail->bank_name = $this->bank_name;
        $paymentDetail->account_name = $this->account_name;
        $paymentDetail->account_number = $this->account_number;
        $paymentDetail->save();
        // session()->flash('success',"Class Updated!");
        $this->emit('toast:success', [
            'text' => "Payment Detail Updated!",
            'modalID' => "#add_payment_detail_modal"
        ]);
        $this->cancel();
    }

    public function cancel() {
        $this->update = false;
        $this->resetFields();
        $this->mount();
    }

    public function resetFields() {
        $this->bank_name = '';
        $this->account_name = '';
        $this->account_number = '';
    }


    public function mount() {}


    public function render()
    {
        $paymentDetails = BankPaymentDetails::all();
        return view('livewire.payment.payment-details', compact('paymentDetails'));
    }
}
