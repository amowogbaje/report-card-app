<div>
    <div class="row gutter-sm">
        <div class="col-sm-8 mx-auto">
            <div class="card">
                @if($student->class_stage_id == 6)
                <h5 class="card-header text-center">List of All Subjects in Your Class</h5>
                @elseif($student->class_stage_id == 7)
                <h5 class="card-header text-center">List of General Subjects</h5>
                @endif
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Subject</th>
                                    @if($student->class_stage_id == 7)
                                    <th class="border-0">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($generalSubjects as $subject)
                                    <tr>
                                        <td>{{$subject->name}}</td>
                                        @if($student->class_stage_id == 7)
                                        <td>
                                            @if($subject->studentRegistered($student->id, $subject->id) == 0)
                                            <form>
                                                <input type="checkbox" value="{{$subject->id}}" wire:model= "selectedSubjects">
                                            </form>
                                            @else
                                                <a wire:click="confirmDelete({{$subject->id}})"><i class="fa fa-trash"></i></a>
                                            @endif
                                            
                                        </td>
                                        @endif
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @if($student->class_stage_id == 7)
    <div class="row gutter-sm">
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <h5 class="card-header text-center">{{ucwords($student->category)}} Subjects</h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Subject</th>
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specificSubjects as $subject)
                                    <tr>
                                        <td>{{$subject->name}}</td>
                                        <td>
                                            @if($subject->studentRegistered($student->id, $subject->id) == 0)
                                            <form>
                                                <input type="checkbo" value="{{$subject->id}}" wire:model= "selectedSubjects">
                                            </form>
                                            @else
                                                <a wire:click="confirmDelete({{$subject->id}})"><i class="fa fa-trash"></i></a>
                                            @endif
                                            
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @endif
    <div class="row gutter-sm">
        <div class="col-sm-8 mx-auto">
            <button class="btn btn-success" wire:click="store">Submit</button>
        </div>
    </div>
</div>