<div class="card">
    @if($class_teacher_id != null)
    <h5 class="card-header"> {{$classLevelObject->name}} ({{$classLevelObject->shortname}}) {{$classLevelObject->alias}} Students @livewire('teacher.process-class-result', ['class_id' =>$class_teacher_id])</h5>
    @else 
    <h5 class="card-header">List of Students 
    </h5>
    @endif
    <h5 class="card-header">
        @if($class_teacher_id != null)
            <a href="javascript::void()" wire:click = "downloadTemplate()" class="text-primary link-primary mx-3"><i class="fas fa-download"></i> Download Template</a>
            <a href="javascript::void()" data-toggle="modal" data-target="#upload_student_modal" class="text-primary link-primary mx-3" ><i class="fas fa-cloud"></i> Upload</a>
            <a href="javascript::void()" wire:click = "normalizeNames()" class="text-primary link-primary mx-3"><i class="fas fa-user"></i> Normalize Names</a>
            {{ count($students)}} Students
            <!--<a href="javascript::void()" wire:click = "givepassword()" class="text-primary link-primary mx-3"><i class="fas fa-user"></i> Give Password</a>-->
            
        @endif
        <a href="javascript::void()" wire:click = "downloadStudentList({{$class_teacher_id}})" class="text-primary link-primary mx-3"><i class="fas fa-download"></i> Download Student List</a>
        
        <a href="javascript::void()" data-toggle="modal" data-target="#add_student_modal" class="text-primary link-primary mx-3" > <i class="fas fa-plus"></i> Add Student</a>
    </h5>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">Face</th>
                        <th class="border-0">Firstname</th>
                        <th class="border-0">Lastname</th>
                        <th class="border-0">Registration No</th>
                        <th class="border-0">Guardian Phone</th>
                        <th class="border-0">Class</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>
                                @if(!empty($student->user->profile_pics))
                                    <div class="m-r-10"><img src="{{ url('uploads/'.$student->user->profile_pics)}}" alt="user" class="rounded-circle" width="45"></div>
                                @else
                                    @if($student->user->gender == 'male')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/male-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @elseif($student->user->gender == 'female')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/female-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @endif
                                    
                                @endif
                                
                            </td>
                            <td>{{$student->user->firstname}}</td>
                            <td>{{$student->user->lastname}}</td>
                            <td>{{$student->user->username}}</td>
                            <td>{{$student->guardian_phone}}</td>
                            <td>{{$student->class->shortname}}</td>
                            <td>
                                @if($student->status == 1) 
                                    Active
                                @elseif($student->status == 0)
                                    Left
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/student/profile/'.$student->user_id)}}"><i class="fa fa-eye"></i></a>
                                @if($student->status == 1)
                                <a class="text-danger" wire:click="delete({{$student->id}})"><i class="fa fa-trash"></i></a>
                                @elseif($student->status == 0)
                                <a class="text-success" wire:click="restore({{$student->id}})"><i class="fa fa-recycle"></i></a>
                                @endif
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="upload_student_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                            <div class="form-group mb-2">
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" placeholder="Upload File Here" wire:model.defer="file">
                                @error('file') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div wire:loading>Processing....</div>
                        {{-- </div> --}}
                        
                        
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button wire:click.prevent="upload()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="add_student_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{-- <div class="form-inline mb-3"> --}}
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstName" placeholder="Enter First Name" wire:model.defer="firstname">
                                @error('firstname') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastName" placeholder="Enter Last Name" wire:model.defer="lastname">
                                @error('lastname') <span class="text-danger">{{ $message }}</span>@enderror
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
                            

                            <div class="form-group mb-2">
                                <select class="form-control @error('class_id') is-invalid @enderror" id="class_id" wire:model.defer="class_id">
                                    <option value="" @selected(true)>Select Class</option>
                                    @foreach ($classlevels as $classlevel)
                                        <option value="{{$classlevel->id}}">{{$classlevel->name}} {{$classlevel->alias}}</option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            
                            @if($classStageIsSecondary)
                            <div class="form-group mb-2">
                                <select class="form-control @error('category') is-invalid @enderror" id="category" wire:model.defer="category">
                                    <option value="general" @selected(true)>General</option>
                                    <option value="science" @selected(true)>Science</option>
                                    {{-- <option value="commercial" @selected(true)>Commercial</option> --}}
                                    <option value="art" @selected(true)>Art</option>
                                </select>
                                @error('category') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            @endif

                        {{-- </div> --}}
                        {{-- <div class="form-inline mb-3"> --}}
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email" wire:model.defer="email">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <!--<div class="form-group mb-2">-->
                            <!--    <input type="text" class="form-control @error('admission_no') is-invalid @enderror" id="email" placeholder="Enter Admission No" wire:model.defer="admission_no">-->
                            <!--    @error('admission_no') <span class="text-danger">{{ $message }}</span>@enderror-->
                            <!--</div>-->
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Guardian Phone Number" wire:model.defer="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" wire:model.defer="gender">
                                    <option value="" @selected(true)>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" id="guardian_name" placeholder="Enter Guardian Name" wire:model.defer="guardian_name">
                                @error('guardian_name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('guardian_address') is-invalid @enderror" id="guardian_address" placeholder="Enter Guardian Address" wire:model.defer="guardian_address">
                                @error('guardian_address') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            
                            {{-- <div class="form-group mb-2">
                                <input type="text" class="form-control @error('student_phone') is-invalid @enderror" id="student_phone" placeholder="Enter Student Phone Number" wire:model.defer="student_phone">
                                @error('student_phone') <span class="text-danger">{{ $message }}</span>@enderror
                            </div> --}}
                        {{-- </div> --}}
                        
                        
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button wire:click.prevent="store()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
