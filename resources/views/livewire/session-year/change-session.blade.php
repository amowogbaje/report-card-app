<div>
    <div class="my-1"><a href="#" data-toggle="modal" data-target="#change_session_modal" class="btn btn-block btn-primary text-center">Change Session</a></div>
    <div class="modal fade" id="change_session_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="sessionYearID">Session Year</label>
                            <select class="form-control" id="sessionYearID" wire:model.defer="session_year_id" required>
                                @foreach ($sessionYears as $sessionYear)
                                    <option value="{{$sessionYear->id}}">{{$sessionYear->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            
                            
                        </div>
                        <div class="form-group">
                            <label for="termID">Term</label>
                            <select class="form-control" id="termID" wire:model.defer="term_id">
                                @foreach ($terms as $term)
                                    <option value="{{$term->id}}">{{$term->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <a href="#" wire:click = 'activateSession()' class="btn btn-primary">Save changes</a>
                </div>
            </div>
        </div>
    </div>
</div>
