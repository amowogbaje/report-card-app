<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Examify App</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
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
        
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('change-password-action')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">New Password</h6>
                            </div>
                            <div class="col-sm-8 text-primary">
    
                                <input type="password" name="password" class="form-control" placeholder="Type New Password Here" value="">
                                @if($user_id == null)
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                @else
                                <input type="hidden" name="user_id" value="{{$user_id}}">
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Confirm Password</h6>
                            </div>
                            <div class="col-sm-8 text-primary">
                                <input type="password" name="cpassword" placeholder="Retype to Confirm Password" class="form-control" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-primary">
                                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.profile-update')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
    
                                <input type="text" name="firstname" class="form-control" value="{{$user->firstname}}">
                                <input type="hidden" name="user_id" class="form-control" value="{{$user->id}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Last Name (i.e. Surname)</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="lastname" class="form-control" value="{{$user->lastname}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Middle Name</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="othernames" class="form-control" value="{{$user->othernames}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="email" class="form-control" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    @if($user->gender == 'male') 
                                        <option value="male" selected>Male</option>
                                        <option value="female" >Female</option>
                                    
                                    @elseif($user->gender == 'female')
                                        <option value="male" >Male</option>
                                        <option value="female" selected>Female</option>

                                    @else 
                                        <option value="male" >Male</option>
                                        <option value="female" >Female</option>
                                    @endif

                                </select>
                                @error('gender') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="address" class="form-control" value="{{$user->address}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Citizenship</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="citizenship" class="form-control" value="{{$user->citizenship}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">State of Origin</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="state_origin" class="form-control" value="{{$user->state_origin}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">LGA of Origin</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="text" name="lga_origin" class="form-control" value="{{$user->lga_origin}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Date of Birth</h6>
                            </div>
                            <div class="col-sm-9 text-primary">
                                <input type="date" name="dob" class="form-control" value="{{$user->dob}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-primary">
                                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
            
        </div> --}}
    </div>
</x-admin-layout>