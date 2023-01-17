<div class="card">
    <h5 class="card-header">List of Classes <a href="#" wire:click="add()"  data-toggle="modal" data-target="#add_class_modal"><i class="fs-2 fa fa-plus"></i></a></h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                    <tr class="border-0">
                        {{-- <th class="border-0">Name</th> --}}
                        <th class="border-0">Name</th>
                        <th class="border-0">Alias</th>
                        <th class="border-0">Code</th>
                        <th class="border-0">Teacher</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classlevels as $classlevel)
                        <tr>
                            {{-- <td>{{$classlevel->name}}</td> --}}
                            <td>{{$classlevel->name}}</td>
                            <td>{{$classlevel->alias}}</td>
                            <td>{{$classlevel->code}}</td>
                            @if($classlevel->teacher($classlevel->id)->count() != 0)
                                <td>
                                    {{$classlevel->teacher($classlevel->id)->first()->firstname}} 
                                    {{$classlevel->teacher($classlevel->id)->first()->lastname}}
                                </td>
                            @else
                                <td>Not Yet Assigned</td>
                            @endif
                            {{-- <td>{{($classlevel->teacherfullname)}}</td> --}}
                            
                            
                            <td>
                                <a href="#" title="Assign a Teacher" onclick="pickClassId({{$classlevel->id}})" data-toggle="modal" data-target="#assign_teacher_to_class_modal"><i class="fas fa-user-plus"></i></a>
                                <a href="#" wire:click="edit({{$classlevel->id}})"  data-toggle="modal" data-target="#add_class_modal"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="assign_teacher_to_class_modal" tabindex="-1" role="dialog"
    aria-labelledby="assignTeacherToClassModal" aria-hidden="true">
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
                            <select class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id"
                                wire:model.defer="teacher_id" required>
                                <option value="NULL" selected>Select an Option</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->user->full_name}}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <input type="hidden" id="classId" wire:model="class_id">
                    <button wire:click="assignTeachers()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="add_class_modal" tabindex="-1" role="dialog"
    aria-labelledby="addClassModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="add_class_teacher" class="modal-title">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-2">
                            <select class="form-control @error('class_stage_id') is-invalid @enderror" id="class_stage_id" wire:model.defer="class_stage_id">
                                <option value="" @selected(true)>Select Class Stage</option>
                                @foreach ($class_stages as $class_stage)
                                    <option value="{{$class_stage->id}}">{{$class_stage->name}}</option>
                                @endforeach
                            </select>
                            @error('class_stage_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Class Name" wire:model.defer="name">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('shortname') is-invalid @enderror" id="shortname" placeholder="Enter Short Name" wire:model.defer="shortname">
                            @error('shortname') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('alias') is-invalid @enderror" id="alias" placeholder="Enter Class Alias" wire:model.defer="alias">
                            @error('alias') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="alias" placeholder="Enter Class Code" wire:model.defer="code">
                            @error('code') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        {{-- <div class="form-group mb-2">
                            <input type="text" class="form-control @error('school_fee') is-invalid @enderror" id="school_fee" placeholder="Enter School Fee" wire:model.defer="school_fee">
                            @error('school_fee') <span class="text-danger">{{ $message }}</span>@enderror
                        </div> --}}
                    </form>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="pick">Like Post</button> --}}
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <input type="hidden" id="classId" wire:model="class_id">
                    @if($update)
                    <button wire:click="update_class()" class="btn btn-primary">Update Class</button>
                    @else
                    <button wire:click="add_class()" class="btn btn-primary">Save Changes</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function pickClassId(id) {
            @this.class_id = id;
        }
        function update(value) {
            @this.class_id = value;
        }
    </script>
</div>

