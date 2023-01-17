<div>
    @if($resultIsReady)
            <h1 class="h3 mb-2 text-gray-800">{{$student->user->full_name}} 
                <a class="btn btn-primary" href="{{url('student/'.$student->id.'/download-result')}}">Download Report Card</a>
            </h1>
        @else
            <h1 class="h3 mb-2 text-gray-800">{{$student->user->full_name}} 
                <a wire:click = "check" class="btn btn-primary" data-toggle="modal" data-target="#show_checklist" href="{{url('student/'.$student->id.'/download-result')}}">Download Report Card</a>
            </h1>
            {{-- Instead do a checklist --}}
            
        @endif

        <div wire:ignore.self class="modal fade" id="show_checklist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="checkbox" {{$checklist['physicalAssessmentsFilled']}} class="custom-control-input"><span class="custom-control-label">Physical Assessment(by Student)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['academicAssessmentsFilled']}} class="custom-control-input"><span class="custom-control-label">Academic Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['behaviourAssessmentsFilled']}} class="custom-control-input"><span class="custom-control-label">Behaviour Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['skillAssessmentsFilled']}} class="custom-control-input"><span class="custom-control-label">Skill Assessment(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['teacherCommentFilled']}} class="custom-control-input"><span class="custom-control-label">Comment on Student(by Teacher)</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" {{$checklist['principalCommentFilled']}} class="custom-control-input"><span class="custom-control-label">Comment on Student(by Principal)</span>
                                </label>
                            </div>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
</div>
