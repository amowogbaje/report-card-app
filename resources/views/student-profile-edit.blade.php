<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Examify App</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard </a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li> --}}
                        </ol>
                    </nav>
                </div>
                @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                @endif
                @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    @if(!empty($student->user->profile_pics))
                        <img src="{{$student->user->profile_pics}}" alt="user" class="rounded" width="110">
                        @else
                        @if($student->user->gender == 'male')
                            <img src="{{asset('assets/images/male-avatar.png')}}" alt="Student" class="rounded-circle p-1 bg-primary" width="110">
                        @elseif($student->user->gender == 'female')
                            <img src="{{asset('assets/images/female-avatar.png')}}" alt="Student" class="rounded-circle p-1 bg-primary" width="110">
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
                    <form action="{{route('student.profile-edit-action')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="firstname" class="form-control" value="{{$student->user->firstname}}">
                                <input type="hidden" name="student_id" class="form-control" value="{{$student->id}}">
                                <input type="hidden" name="user_id" class="form-control" value="{{$student->user->id}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Last Name (i.e. Surname)</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="lastname" class="form-control" value="{{$student->user->lastname}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Middle Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="othernames" class="form-control" value="{{$student->user->othernames}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="email" class="form-control" value="{{$student->user->email}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Class: <span class="text-danger"> Currently in {{$student->class->name}}</span></h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <select class="form-control @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                                    @foreach ($classlevels as $classlevel)
                                        <option value="{{$classlevel->id}}">{{$classlevel->name}} {{$classlevel->alias}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Guardian Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="guardian_phone" class="form-control" value="{{$student->guardian_phone}}">
                            </div>
                        </div>
                        @if($student->category == "" && $student->class_stage_id == 7)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Category</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <div class="form-group mb-2">
                                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                        {{-- <option value="general" @selected(true)>General</option> --}}
                                        <option value="science" @selected(true)>Science</option>
                                        {{-- <option value="commercial">Commercial</option> --}}
                                        <option value="art" >Art</option>
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
                                <input type="text" name="phone" class="form-control" value="{{$student->user->phone}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Guardian Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="guardian_address" class="form-control" value="{{$student->user->address}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Citizenship</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="citizenship" class="form-control" value="{{$student->user->citizenship}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">State of Origin</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="state_origin" class="form-control" value="{{$student->user->state_origin}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">LGA of Origin</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="lga_origin" class="form-control" value="{{$student->user->lga_origin}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Date of Birth</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="date" name="dob" class="form-control" value="{{$student->user->dob}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                <a href="{{url('student/profile/'.$student->user->id)}}" class="btn btn-primary px-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-admin-layout>