<div class="container-fluid">
    <div class="row mx-auto">
        @foreach($paymentDetails as $key => $paymentDetail)
        <div class="col-md-4">
            <div class="card">
                <h5 class="text-center text-secondary px-2 pt-3">Payment Details {{$key+1}}</h5>
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <h6 class="mb-0">Bank Name</h6>
                  <span class="text-primary">{{$paymentDetail->bank_name}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Account Name</h6>
                    <span class="text-primary">{{$paymentDetail->account_name}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Account Number</h6>
                    <span class="text-primary">{{$paymentDetail->account_number}}</span>
                </li>
              </ul>
            </div>
            
            {{-- <div class="mt-3"></div> --}}
            
        </div>
        @endforeach
        
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 mb-3">


            @if(count($approvedTransactions) > 0)
            <div class="card">
                <h5 class="text-center text-secondary h3 px-2 pt-3">Approved Payments</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($approvedTransactions as $key => $transaction)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Payment #{{$key}}</h6>
                            <span class="text-primary">N{{$transaction->amount}}</span>
                      </li>
                    @endforeach
                    
                </ul>
                <button class="btn btn-secondary" wire:click = 'pay'>Pay</button>
            </div>

            @else
            <div class="card">
                <h5 class="text-center text-secondary h3 px-2 pt-3">No Payment Has been made Yet</h5>
              
            </div>
            @endif
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="post" >
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0 lead py-2">Amount to be Paid</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <input type="number" wire:model="amount" class="form-control @error('amount') is-invalid @enderror form-control-lg" value="">
                                @error('amount') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @if($showBankTransferForms)
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0 lead py-2">Your account name</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <input type="text" wire:model="student_account_name" class="form-control form-control-lg @error('student_account_name') is-invalid @enderror" placeholder="The Account Name You are Sending Money from">
                                @error('student_account_name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0 lead py-2">Choose School Account</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <select wire:model="payment_detail_id" class="form-control form-control-lg @error('payment_detail_id') is-invalid @enderror">
                                    @foreach($paymentDetails as $paymentDetail)
                                        <option value="{{$paymentDetail->id}}">{{$paymentDetail->bank_name}}</option>
                                    @endforeach
                                    
                                </select>
                                @error('payment_detail_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0 lead py-2">Payment Method</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <select wire:change = "paymentOption" wire:model="payment_method" id="" class="form-control form-control-lg @error('payment_method') is-invalid @enderror"">
                                    <option value="">Select Payment Method</option>
                                    <option value="atm">ATM</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="deposit_by_hand">Deposit by Hand</option>
                                </select>
                                @error('payment_method') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8 text-secondary">
                                <button wire:click = "choose" type="button" class="btn btn-primary px-4">Proceed</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <hr>
    <div class="row">
        {{-- <div class="col-lg-4 col-sm-4">
            @if(count($depositByHandTransactions))
            <div class="card">
                <h5 class="card-header">Deposit By Hand</h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depositByHandTransactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->amount}}</td>
                                        <td>{{($transaction->status)}}</td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div>Looking to put a good gif here</div>
            @endif
            
        </div> --}}
        <div class="col-lg-12 col-sm-12">
            @if(count($bankTransferTransactions) > 0)
            <div class="card">
                <h5 class="card-header">Bank Transfers</h5>
                <div class="card-body px-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Reference No.</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Bank Name</th>
                                    <th class="border-0">Account Name</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankTransferTransactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->ref_no}}</td>
                                        <td>{{$transaction->amount}}</td>
                                        <td>{{$transaction->paymentDetails->bank_name}}</td>
                                        <td>{{$transaction->student_account_name}}</td>
                                        <td>{{($transaction->status)}}</td>
                                        
                                        <td>
                                            <a class="btn btn-warning" href="#" title="Upload Proof" onclick="pickTransactionId({{$transaction->id}})" data-toggle="modal" data-target="#upload_proof_modal">Upload Proof</a>
                                            @if($transaction->proof_url != NULL)
                                                <a class="btn btn-info" href="#" title="View Proof" onclick="setTransactionImage('{{$transaction->proof_url}}')" data-toggle="modal" data-target="#view_proof_modal"><i class="fa fa-eye"></i></a>
                                            @endif
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div>Looking to put a good gif here</div>
            @endif
            
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="upload_proof_modal" tabindex="-1" role="dialog"
    aria-labelledby="UploadProofModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="assign_teacher_topic" class="modal-title">Upload Proof Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <input class="custom-file" type="file" wire:model="proof">
                            @error('proof') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    {{-- <input type="hidden" id="classId" wire:model="trab"> --}}
                    <button wire:click="uploadProof()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

        
    </div>
    <div wire:ignore.self class="modal fade" id="view_proof_modal" tabindex="-1" role="dialog"
    aria-labelledby="ViewProofModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="proof-image" src="{{URL::asset("assets/images/avatar-1.jpg")}}" alt="" class="img-fluid">
                    {{-- <img src="{{URL::asset("assets/images/avatar-1.jpg")}}" alt="" class="img-fluid container-fluid"> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function pickTransactionId(id) {
            @this.transaction_id = id;
        }
        function setTransactionImage(value) {
            pathBase = "{{URL::asset('uploads')}}"
            imageUrl = pathBase+'/'+value;
            document.getElementById('proof-image').src = imageUrl
        }
    </script>
</div>