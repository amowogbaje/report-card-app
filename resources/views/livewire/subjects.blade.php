<div class="card">
    <h5 class="card-header">List of Subject 
        <a href="#" wire:click="add()"  data-toggle="modal" data-target="#add_subject_term_modal">
            <i class="fs-2 fa fa-plus"></i>
        </a>
        <!--<a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#add_many_subject_modal">-->
        <!--    Add In Bulk-->
        <!--</a>-->
    </h5>
    <h5>Junior Subjects: {{$noOfJuniorSubjects}}, Senior Subjects: {{$noOfSeniorSubjects}} </h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table first">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">Name</th>
                        <th class="border-0">Level</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subject_for_term as $subject_term)
                        <tr>
                            <td>{{$subject_term->subject->name}}</td>
                            <td>{{$subject_term->class_stage->name}}</td>
                            
                            
                            <td>
                                <a href="#" wire:click="selectSubject" onclick="pickSubjectId({{$subject_term->subject_id}})" data-toggle="modal" data-target="#assign_teacher_to_subject_modal"><i class="fa fa-tags"></i>Assign Teacher</a>
                                {{-- <a href="#" onclick="update({{$subject_term->subject_id}})" wire:click="edit({{$subject_term->subject_id}})"  data-toggle="modal" data-target="#add_subject_term_modal"><i class="fa fa-edit"></i></a> --}}
                                {{-- <a href="#" wire:click="delete({{$subject_term->subject_id}})"><i class="fa fa-trash"></i></a> --}}
                                {{-- <a href="#" wire:click="delete({{$subject_term->subject_id}})"  data-toggle="modal"><i class="fa fa-trash"></i></a> --}}
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

    <div wire:ignore.self class="modal fade" id="add_subject_term_modal" tabindex="-1" role="dialog"
    aria-labelledby="addSubjectModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject to Term</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <select class="form-control @error('subject_id') is-invalid @enderror" id="subject_id" wire:model.defer="subject_id">
                                <option value="" @selected(true)>Select Subject to Add</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}} {{$subject->class_stage->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        

                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                   
                    <button wire:click="add_subject_to_list()" class="btn btn-primary">Add Subject to this Term</button>
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

