<div class="row">
    <div class="card">
        <div class="card-header tab-regular">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="card-tab-1" data-toggle="tab" href="#card-1" role="tab" aria-controls="card-1" aria-selected="true">Create Session</a>
                    <p class="text-center">
                        @if(!$noSessionAtAll)
                            {{$currentSession->name}}
                        @endif
                    </p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="card-tab-2" data-toggle="tab" href="#card-2" role="tab" aria-controls="card-2" aria-selected="false">Add Subjects</a>
                </li>
                <li class="nav-item">
                    @if(isset(active_term()->id))
                    <a class="nav-link text-muted" id="card-tab-3" data-toggle="tab" href="#card-3" role="tab" aria-controls="card-3" aria-selected="false">Activated</a>
                    @else
                    <a class="nav-link" id="card-tab-3" data-toggle="tab" href="#card-3" role="tab" aria-controls="card-3" aria-selected="false">Activate</a>
                    @endif
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="card-tab-4" data-toggle="tab" href="#card-4" role="tab" aria-controls="card-4" aria-selected="false">Assign Teachers</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="card-1" role="tabpanel" aria-labelledby="card-tab-1">
                    @if($noSessionAtAll)
                        @livewire('session-year.add-session')
                    @else 
                        <form>
                            <button wire:click.prevent="createNextSession" class="btn btn-block btn-primary">Create Next Session</button>
                        </form>
                        
                    @endif
                </div>
                <div class="tab-pane fade" id="card-2" role="tabpanel" aria-labelledby="card-tab-2">
                    @livewire('subjects', ['number' => 30])
                </div>
                <div class="tab-pane fade" id="card-3" role="tabpanel" aria-labelledby="card-tab-2">
                    @livewire('session-year.change-session')
                </div>
                
                <div class="tab-pane fade" id="card-4" role="tabpanel" aria-labelledby="card-tab-3">
                    @if(isset(active_term()->id))
                        @livewire('session-year.teacher-subject-assignment')
                    @else
                        Activate the term before checking this tab
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>