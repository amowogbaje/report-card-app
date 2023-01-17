<div class="card">
    <h5 class="card-header">Payment Details </h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">Reference No</th>
                        <th class="border-0">Amount</th>
                        <th class="border-0">Student Name</th>
                        <th class="border-0">Payment Method</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentTransactions as $key => $paymentTransaction)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$paymentTransaction->ref_no}}</td>
                            <td>{{$paymentTransaction->amount}}</td>
                            <td>{{$paymentTransaction->student_id}}</td>
                            <td>{{$paymentTransaction->payment_method}}</td>
                            <td>
                                <a href="#" wire:click="approve({{$paymentTransaction->id}})"><i class="fa fa-mark"></i></a>
                                <a href="#" wire:click="dismiss({{$paymentTransaction->id}})"><i class="fa fa-cancel"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>