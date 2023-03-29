<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    @if(!empty($student->user->profile_pics))
                    <img src="{{url('uploads/'.$student->user->profile_pics)}}" alt="user" class="rounded-circle"
                        width="110">
                    @else
                    @if($student->user->gender == 'male')
                    <img src="{{asset('assets/images/male-avatar.png')}}" alt="Student"
                        class="rounded-circle p-1 bg-primary" width="110">
                    @elseif($student->user->gender == 'female')
                    <img src="{{asset('assets/images/female-avatar.png')}}" alt="Student"
                        class="rounded-circle p-1 bg-primary" width="110">
                    @endif
                    @endif
                    <div class="mt-3">
                        <h4>{{$student->user->full_name}}</h4>
                        <p class="text-primary mb-1">{{$student->class->shortname}} Student</p>
                        <p class="text-muted font-size-sm">{{$student->user->address}}</p>
                        {{-- <a href="{{ url('/')}}" class="btn btn-primary">Academic Report</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">First Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="firstname" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Last Name (i.e. Surname)</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="lastname" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Middle Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="othernames" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Class: <span class="text-danger"> Currently in
                                    {{$student->class->name}}</span></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select class="form-control @error('class_id') is-invalid @enderror" id="class_id"
                                wire:model="class_id">
                                @foreach ($classlevels as $classlevel)
                                <option value="{{$classlevel->id}}">{{$classlevel->name}} {{$classlevel->alias}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Guardian Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="guardian_phone" class="form-control">
                        </div>
                    </div>
                    @if($student->category == "" && $student->class_stage_id == 7)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Category</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <div class="form-group mb-2">
                                <select class="form-control @error('category') is-invalid @enderror" id="category"
                                    wire:model="category">
                                    {{-- <option value="general" @selected(true)>General</option> --}}
                                    <option value="science" @selected(true)>Science</option>
                                    {{-- <option value="commercial">Commercial</option> --}}
                                    <option value="art">Art</option>
                                </select>
                                @error('category') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Student Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="phone" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Guardian Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="guardian_address" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Citizenship</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="citizenship" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">State of Origin</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="state_origin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">LGA of Origin</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" wire:model="lga_origin" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Date of Birth</h6>
                        </div>
                        <div class="col-sm-9 text-primary">
                                <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                    <input type="text" wire:model="dob" class="form-control" placeholder="Select Date" readonly>
                                    <div class="input-group-prepend">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 text-secondary">
                            <button wire:click.prevent="update" class="btn btn-primary px-4">Save Changes</button>
                            <a href="{{url('student/profile/'.$student->user->id)}}"
                                class="btn btn-primary px-4">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@section('extra-script')
<script>
    $(function () {
          $("#datepicker").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: 'yyyy-mm-dd'
          }).on('change', function (e) {
       @this.set('dob', e.target.value);
});;
        });
</script>
@endsection