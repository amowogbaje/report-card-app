<div >
    <div class="my-1">
        <a href="#" data-toggle="modal" data-target="#add_teacher_modal" class="btn btn-block btn-primary text-center">Add Teacher</a>
    </div>
    
    <div wire:ignore.self class="modal fade" id="add_teacher_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- <div class="form-inline mb-3"> --}}
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstName" placeholder="Enter First Name" wire:model.defer="firstname">
                                @error('firstname') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastName" placeholder="Enter Last Name" wire:model.defer="lastname">
                                @error('lastname') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        {{-- </div> --}}
                        {{-- <div class="form-inline mb-3"> --}}
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email" wire:model.defer="email">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Phone Number" wire:model.defer="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" wire:model.defer="gender">
                                    <option value="male" @selected(true)>Male</option>
                                    <option value="female" selected>Female</option>
                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        {{-- </div> --}}
                        
                        
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button wire:click.prevent="store()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
