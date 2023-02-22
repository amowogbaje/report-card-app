<div class="card shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <input type="text" class="form-control @error('student_attendance') is-invalid @enderror" id="student_attendance" placeholder="Enter Student Total Attendance" wire:model.defer="student_attendance">
            @error('student_attendance') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group mb-2">
            <input type="text" class="form-control @error('overall_attendance') is-invalid @enderror" id="overall_attendance" placeholder="Enter Overall Attendance" wire:model.defer="overall_attendance">
            @error('overall_attendance') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
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
