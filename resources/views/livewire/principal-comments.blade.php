<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <label for="">Principal's Comment</label>
            <textarea class="form-control @error('principal_comment') is-invalid @enderror" id="" cols="30" rows="10" wire:model.defer="principal_comment"></textarea>
            @error('principal_comment') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="card-footer">
        <button wire:click.prevent="store()" class="btn btn-success">Save changes</button>
        @if(active_term()->id == 3)
            <div class="form-group mb-2">
                <select class="form-control @error('class_id') is-invalid @enderror" wire:model ='class_id'>
                    @foreach ($classlevels as $classlevel)
                        <option value="{{$classlevel->id}}">{{$classlevel->name}} {{$classlevel->alias}}</option>
                    @endforeach
                </select>
                @error('class_id') <span class="text-danger">{{ $message }}</span>@enderror
                <button wire:click.prevent="promote()" class="btn btn-primary">Promote Student</button>
            </div>
        @endif
    </div>
</div>
