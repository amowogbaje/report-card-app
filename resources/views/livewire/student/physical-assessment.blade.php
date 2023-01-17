<div >
    <div class="card my-1">
        {{-- Assessment Links --}}
        <a class="btn btn-info" data-toggle="modal" data-target="#physical_assessment_modal" target="_blank" href="#">Fill your physical Assessment</a>
      </div>
    
    <div wire:ignore.self class="modal fade" id="physical_assessment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Physical Assessment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- <div class="form-inline mb-3"> --}}
                            <input type="hidden" id="age" wire:model.defer="age" disabled>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" placeholder="Your Weight Here" wire:model.defer="weight">
                                @error('weight') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('height') is-invalid @enderror" id="height" placeholder="Your Height Here" wire:model.defer="height">
                                @error('height') <span class="text-danger">{{ $message }}</span>@enderror
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
