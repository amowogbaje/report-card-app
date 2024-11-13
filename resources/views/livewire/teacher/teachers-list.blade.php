<div class="card">
    <h5 class="card-header">List of Teachers</h5>
    <h5 class="card-header">
        <a href="javascript::void()" wire:click = "downloadTemplate()" class="text-primary link-primary mx-3"><i class="fas fa-download"></i> Download Template</a>
        <a href="javascript::void()" data-toggle="modal" data-target="#upload_teacher_modal" class="text-primary link-primary mx-3" ><i class="fas fa-cloud"></i> Upload</a>
        <a href="javascript::void()" wire:click = "download()" class="text-primary link-primary mx-3"><i class="fas fa-download"></i> Download</a>
        <a href="javascript::void()" data-toggle="modal" data-target="#add_teacher_modal" class="text-primary link-primary mx-3" > <i class="fas fa-plus"></i> Add Teacher</a>
    </h5>
    <div class="card-body mb-5">
        <div class="table-responsive">
            <table class="table first">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">Face</th>
                        <th class="border-0">Firstname</th>
                        <th class="border-0">Lastname</th>
                        <th class="border-0">Phone</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td>
                                @if(!empty($teacher->user->profile_pics))
                                    <div class="m-r-10"><img src="{{url('uploads/'.$teacher->user->profile_pics)}}" alt="user" class="rounded-circle" width="45"></div>
                                @else
                                    @if($teacher->user->gender == 'male')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/male-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @elseif($teacher->user->gender == 'female')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/female-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @endif
                                    
                                @endif
                                
                            </td>
                            <td>{{$teacher->user->firstname}}</td>
                            <td>{{$teacher->user->lastname}}</td>
                            <td>{{$teacher->user->phone}}</td>
                            <td>{{$teacher->user->email}}</td>
                            <td>
                                <a href="{{url('/teacher/profile/'.$teacher->user_id)}}"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-danger mr-2" wire:click = "delete({{$teacher->id}})"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <h5 class="card-header"> Deleted Teachers</h5>
    <div class="card-body ">
        <div class="table-responsive">
            <table class="table first">
                <thead class="bg-light">
                    <tr class="border-0">
                        <th class="border-0">Face</th>
                        <th class="border-0">Firstname</th>
                        <th class="border-0">Lastname</th>
                        <th class="border-0">Phone</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inactive_teachers as $teacher)
                        <tr>
                            <td>
                                @if(!empty($teacher->user->profile_pics))
                                    <div class="m-r-10"><img src="{{url('uploads/'.$teacher->user->profile_pics)}}" alt="user" class="rounded-circle" width="45"></div>
                                @else
                                    @if($teacher->user->gender == 'male')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/male-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @elseif($teacher->user->gender == 'female')

                                        <div class="m-r-10"><img src="{{ URL::asset('assets/images/female-avatar.png') }}" alt="user" class="rounded" width="45"></div>
                                    
                                    @endif
                                    
                                @endif
                                
                            </td>
                            <td>{{$teacher->user->firstname}}</td>
                            <td>{{$teacher->user->lastname}}</td>
                            <td>{{$teacher->user->phone}}</td>
                            <td>{{$teacher->user->email}}</td>
                            <!--<td><a href="{{url('/teacher/profile/'.$teacher->user_id)}}"><i class="fa fa-eye"></i></a></td>-->
                            <td><a class="btn btn-success" wire:click = "restore({{$teacher->id}})"><i class="fa fa-recycle"></i></a></td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="upload_teacher_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                            <div class="form-group mb-2">
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" placeholder="Upload File Here" wire:model="file">
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
    <div wire:ignore.self class="modal fade" id="add_teacher_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
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
                        {{-- </div> --}}
                        {{-- <div class="form-inline mb-3"> --}}
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email" wire:model.defer="email">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter Phone Number" wire:model.defer="phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" wire:model.defer="gender">
                                    <option value="male" @selected(true)>Male</option>
                                    <option value="female" selected>Female</option>
                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
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