<div class="card">
    <h5 class="card-header">Payment Details <a href="#"  data-toggle="modal" data-target="#add_payment_detail_modal"><i class="fs-2 fa fa-plus"></i></a></h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">No</th>
                        <th class="border-0">Bank Name</th>
                        <th class="border-0">Account Name</th>
                        <th class="border-0">Account Number</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentDetails as $key => $paymentDetail)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$paymentDetail->bank_name}}</td>
                            <td>{{$paymentDetail->account_name}}</td>
                            <td>{{$paymentDetail->account_number}}</td>
                            <td>
                                <a href="#" wire:click="edit({{$paymentDetail->id}})"  data-toggle="modal" data-target="#add_payment_detail_modal"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="add_payment_detail_modal" tabindex="-1" role="dialog"
    aria-labelledby="addClassModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="add_payment_detail" class="modal-title">Add Payment Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" placeholder="Enter Bank Name" wire:model.defer="bank_name">
                            @error('bank_name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" placeholder="Enter Account Name" wire:model.defer="account_name">
                            @error('account_name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" placeholder="Enter Account Number" wire:model.defer="account_number">
                            @error('account_number') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <input type="hidden" id="paymentDetailId" wire:model="payment_detail_id">
                    @if($update)
                    <button wire:click="update_payment_detail()" class="btn btn-primary">Update Class</button>
                    @else
                    <button wire:click="add_payment_detail()" class="btn btn-primary">Save Changes</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
