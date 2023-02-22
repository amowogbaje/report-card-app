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
            </div>
        </div>
    </div>
    <div class="row gutters-sm">
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
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                  @if(!empty($user->profile_pics))
                      <img src="{{url('uploads/'.$user->profile_pics)}}" alt="user" class="rounded-circle" width="110">
                  @else
                      @if($user->gender == 'male')
                      <img src="{{asset('assets/images/male-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                      @elseif($user->gender == 'female')
                      <img src="{{asset('assets/images/female-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                      @endif
                  @endif
                        <div class="mt-3">
                            <h4>{{$user->full_name}}</h4>
                            @if($user->address != "")
                            <p class="text-muted font-size-sm">{{$user->address}}</p>
                            @endif
                            {{-- @if($class_id == "")
                              <a href="#" class="btn btn-primary" data-toggle="modal"
                                data-target="#assign_teacher_to_class_modal">Assign to Class</a>
                            @endif --}}
      
      
                            {{-- <a href="teacher-students-report-sheet.html" class="btn btn-primary">Academic Report</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Complete your Profile to have this section show</h6>
                    </li>
                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="mb-0">Age</h6>
                <span class="text-primary">14</span>
              </li> --}}
                    @if($user->dob != "")
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Date of Birth</h6>
                        <span class="text-primary">{{$user->dob_month_day}}</span>
                    </li>
                    @endif
                    @if($user->citizenship)
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Citizenship</h6>
                        <span class="text-primary">{{$user->citizenship}}</span>
                    </li>
                    @endif
                    @if($user->state_origin)
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">State of Origin</h6>
                        <span class="text-primary">{{$user->state_origin}}</span>
                    </li>
                    @endif
                    @if($user->lga_origin)
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">LGA of Origin</h6>
                        <span class="text-primary">{{$user->lga_origin}}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-primary">
                            {{$user->full_name}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-primary">
                            {{$user->email}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-primary">
                            {{$user->phone}}
                        </div>
                    </div>
                    @if($user->address != '')
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-primary">
                            {{$user->address}}
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-info " target="_blank"
                                href="{{url('/admin/profile/edit')}}">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
      
      
      
      
        </div>
      
        
    </div>
</x-admin-layout>