<div >
    <div class="my-1">
        <a href="#" data-toggle="modal" data-target="#add_session_modal" class="btn btn-block btn-primary text-center">Add Session</a>
    </div>
    
    <div class="modal fade" id="add_session_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="sessionName" placeholder="Enter Name" wire:model.defer="name">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
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
