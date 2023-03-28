<div>
    @if($noOfResults !=0) 
        @if($allSubjectsInClassIsProcessed)
        <button class="btn btn-primary mx-3" wire:click="process">Process Class Result </button>
        @elseif(!$allSubjectsInClassIsProcessed) 
        <button data-toggle="modal" data-target="#show_subject_teacher_remaining" class="btn btn-primary mx-3">Waiting for all subjects to be processed</button>
        @endif
    @endif


    <div wire:ignore.self class="modal fade" id="show_subject_teacher_remaining" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary">All Teachers has to collate their result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <ul class="list-unstyled arrow">
                                @foreach ($subjectTeachersRemaining as $subjectTeacher)
                                    <li>{{$subjectTeacher->user($subjectTeacher->teacher->user_id)->fullname}} has not completed {{$subjectTeacher->subject->name}} result collation for this class</li>
                                @endforeach
                            </ul>
                            
                            
                        </div>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
