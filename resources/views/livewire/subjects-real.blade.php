<div class="card">
    <h5 class="card-header">List of Subject 
        <a href="#" wire:click="add()"  data-toggle="modal" data-target="#add_subject_modal">
            <i class="fs-2 fa fa-plus"></i>
        </a>
        <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#add_many_subject_modal">
            Add In Bulk
        </a>
    </h5>
    <h5>Junior Subjects: {{$noOfJuniorSubjects}}, Senior Subjects: {{$noOfSeniorSubjects}} </h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table first">
                <thead class="bg-light">
                    <tr class="border-0">
                        {{-- <th class="border-0">Name</th> --}}
                        <th class="border-0">Name</th>
                        <th class="border-0">Level</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{$subject->name}}</td>
                            <td>{{$subject->class_stage->name}}</td>
                            {{-- <td>{{$classlevel->alias}}</td> --}}
                            
                            
                            <td>
                                <a href="#" wire:click="selectSubject" onclick="pickSubjectId({{$subject->id}})" data-toggle="modal" data-target="#assign_teacher_to_subject_modal"><i class="fa fa-tags"></i></a>
                                <a href="#" onclick="update({{$subject->id}})" wire:click="edit({{$subject->id}})"  data-toggle="modal" data-target="#add_subject_modal"><i class="fa fa-edit"></i></a>
                                {{-- <a href="#" wire:click="delete({{$subject->id}})"><i class="fa fa-trash"></i></a> --}}
                                {{-- <a href="#" wire:click="delete({{$subject->id}})"  data-toggle="modal"><i class="fa fa-trash"></i></a> --}}
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assign_teacher_to_subject_modal" tabindex="-1" role="dialog"
    aria-labelledby="assignTeacherSubjectModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="assign_teacher_topic" class="modal-title">Assign Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <select class="form-control @error('teacher_id') is-invalid @enderror" 
                                wire:model.defer="teacher_id" required>
                                <option value="NULL" selected>Select an Option</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->user->full_name}}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="number" class="form-control @error('periods') is-invalid @enderror" id="number" placeholder="Enter No of Periods" wire:model.defer="periods">
                            @error('periods') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <select wire:change = "hasAssigned" class="form-control @error('class_id') is-invalid @enderror" id="class_id"
                                wire:model.defer="class_id" required>
                                <option value="NULL" selected>Select an Option</option>
                                @foreach ($classlevels as $classlevel)
                                    <option value="{{$classlevel->id}}">{{$classlevel->shortname}} {{$classlevel->alias}}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <input type="hidden" id="subjectId" wire:model="subject_id">
                    <input type="hidden" id="classId" wire:model="class_id">
                    @if($isAssigned)
                    <button wire:click="assignTeachers()" class="btn btn-primary">Update Teacher</button>
                    @else
                    <button wire:click="assignTeachers()" class="btn btn-primary">Save changes</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="add_subject_modal" tabindex="-1" role="dialog"
    aria-labelledby="addSubjectModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Subject Name" wire:model.defer="name">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <select wire:change = "chooseClassStage" class="form-control @error('class_stage_id') is-invalid @enderror" id="class_stage" wire:model.defer="class_stage_id">
                                <option value="" @selected(true)>Select Class Stage</option>
                                @foreach ($class_stages as $class_stage)
                                    <option value="{{$class_stage->id}}">{{$class_stage->name}}</option>
                                @endforeach
                            </select>
                            @error('class_stage_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        @if($classStageIsSecondary)
                        <div class="form-group mb-2">
                            <select class="form-control @error('category') is-invalid @enderror" id="category" wire:model.defer="category">
                                <option value="">General</option>
                                <option value="science">Sciences</option>
                                {{-- <option value="commercial" @selected(true)>Commercial</option> --}}
                                <option value="art">Art</option>
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        @endif


                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    {{-- <input type="hidden" id="classId" wire:model="subject_id"> --}}
                    @if($update)
                    <button wire:click="update_subject()" class="btn btn-primary">Update Subject</button>
                    @else
                    <button wire:click="add_subject()" class="btn btn-primary">Save Changes</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="add_many_subject_modal" tabindex="-1" role="dialog"
    aria-labelledby="addManySubjectModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        
                        <div class="form-group mb-2">
                            <select wire:change = "chooseClassStage" class="form-control @error('class_stage_id') is-invalid @enderror" id="class_stage" wire:model.defer="class_stage_id">
                                <option value="" @selected(true)>Select Class Stage</option>
                                @foreach ($class_stages as $class_stage)
                                    <option value="{{$class_stage->id}}">{{$class_stage->name}}</option>
                                @endforeach
                            </select>
                            @error('class_stage_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        @if($classStageIsSecondary)
                        <div class="form-group mb-2">
                            <select class="form-control @error('category') is-invalid @enderror" id="category" wire:model.defer="category">
                                <option value="">General</option>
                                <option value="science">Science</option>
                                <option value="art">Art</option>
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        @endif
                        <div class="form-group mb-2">
                            <textarea class="form-control @error('listOfSubjects') is-invalid @enderror" id="name" placeholder="Seperate Subjects By Comma" wire:model.defer="listOfSubjects"></textarea>
                            <span class="text-primary pl-1 pt-3">Kindly seperate the Subjects by Comma(,)</span> <br>
                            @error('listOfSubjects') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button wire:click="addManySubjects()" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function update(value) {
            @this.subject_id = value;
        }

        function pickSubjectId(subject_id) {
            @this.subject_id = subject_id;
        }
        


    </script>
</div>

