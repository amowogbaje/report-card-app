<?php

namespace App\Http\Livewire\Payment;

use Livewire\Component;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\PaymentDetails;
use App\Models\Transaction;

class PaymentTransactions extends Component
{
    public function render()
    {
        $paymentTransactions = Transaction::all();
        
        return view('livewire.payment.payment-transactions', compact('paymentTransactions'));
    }
}
