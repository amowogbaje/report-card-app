<div>
    
        <a wire:click = "check" class="btn btn-secondary" data-toggle="modal" data-target="#show_checklist{{$given_session_id."".$given_term_id}}" href="#">Download Report</a>

        <div wire:ignore.self class="modal fade" id="show_checklist{{$given_session_id."".$given_term_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-secondary">Result Not Ready See Checklist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            
                            <div class="form-group mb-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['academicAssessmentsFilled']}} ><span>Academic Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['behaviourAssessmentsFilled']}} ><span>Behaviour Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['skillAssessmentsFilled']}} ><span>Skill Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['teacherCommentFilled']}} ><span>Comment on Student(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['principalCommentFilled']}} ><span>Comment on Student(by Principal)</span>
                                </label>
                                @if(Auth::user()->role != 'admin')
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['student_payment_complete']}} ><span>Student Payment Completed</span>
                                </label>
                                @endif
                            </div>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
</div>
