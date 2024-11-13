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
                    <a class="nav-link" id="card-tab-2" data-toggle="tab" href="#card-2" role="tab" aria-controls="card-2" aria-selected="false" title="Assign teachers here">Add Subjects</a>
                </li>
                @if(isset(active_term()->id))
                <li class="nav-item">
                    <a class="nav-link" id="card-tab-3" data-toggle="tab" href="#card-3" role="tab" aria-controls="card-3" aria-selected="false">Update Classes</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="card-tab-4" data-toggle="tab" href="#card-4" role="tab" aria-controls="card-4" aria-selected="false">Teachers List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" id="card-tab-5" data-toggle="tab" href="#card-5" role="tab" aria-controls="card-5" aria-selected="false">
                        @if(isset(active_term()->id))
                            Activated
                        @else
                            Activate
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="card-tab-6" data-toggle="tab" href="#card-6" role="tab" aria-controls="card-6" aria-selected="false">Assigned Teachers</a>
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
                    @livewire('subjects', ['number' => 55])
                </div>
                @if(isset(active_term()->id))
                <div class="tab-pane fade" id="card-3" role="tabpanel" aria-labelledby="card-tab-3">
                    @livewire('classlevels')
                </div>
                @endif

                <div class="tab-pane fade" id="card-4" role="tabpanel" aria-labelledby="card-tab-4">
                    @livewire('teacher.teachers-list', ['number' => 80])
                </div>
                
                <div class="tab-pane fade" id="card-5" role="tabpanel" aria-labelledby="card-tab-5">
                    @if(isset(active_term()->id))
                        <h4 class="text-center">Term has been actived Kindly complete setup by assign Teachers to Subject. After you have completed allocation kindly reload</h4>
                    @else
                        @livewire('session-year.change-session')
                    @endif
                </div>
                
                <div class="tab-pane fade" id="card-6" role="tabpanel" aria-labelledby="card-tab-6">
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