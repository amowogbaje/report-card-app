<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <label for="">Class Teacher's Comment</label>
            <textarea class="form-control @error('class_teacher_comment') is-invalid @enderror" id="" cols="30" rows="10" wire:model.defer="class_teacher_comment"></textarea>
            @error('class_teacher_comment') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="card-footer">
        <button wire:click.prevent="store()" class="btn btn-success">Save changes</button>
    </div>
</div>
