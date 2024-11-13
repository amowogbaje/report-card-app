<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <label for="">Principal's Comment</label>
            <textarea class="form-control @error('principal_comment') is-invalid @enderror" id="" cols="30" rows="10" wire:model.defer="principal_comment"></textarea>
            @error('principal_comment') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group mb-2">
                @if(!empty(Auth::user()->signature_url))
                    <img src="{{url('uploads/'.Auth::user()->signature_url)}}" alt="user" class="rounded" width="110">
                @endif
        </div>
    </div>
    <div class="card-footer">
        <button wire:click.prevent="store()" class="btn btn-success">Save changes</button>
        @if($promoted)
        <p>Student has been promoted</p>
        <button wire:click.prevent="depromote()" class="btn btn-primary my-2">Remove Student From Promotion List</button>
        @else
            @if(active_term()->id == 3)
                <div class="form-group my-3">
                    <label for="">Promote Student to:</label>
                    <select class="form-control @error('class_id') is-invalid @enderror" wire:model ='class_id'>
                        <option value="">Select Class</option>
                        <option value="{{$promotionStudentClassBranch->id}}">{{removeLastCharacter($promotionStudentClassBranch->shortname)}} {{$promotionStudentClassBranch->alias}}</option>
                    </select>
                    @error('class_id') <span class="text-danger">{{ $message }}</span>@enderror
                    <button wire:click.prevent="promote()" class="btn btn-primary my-2">Promote Student</button>
                </div>
            @endif
        @endif
    </div>
</div>
