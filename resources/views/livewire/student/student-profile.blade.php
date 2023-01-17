<div class="row gutters-sm">
    <div class="col-md-4 mb-3">
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
              @if(Auth::user()->role == 'student')
                @if($student->payment_complete)
                  <a href="{{url('/student/'.$student->id.'/academic-report')}}" class="btn btn-primary">Academic Report</a>
                @else
                  <a href="javascript::void()" wire:click ="report" class="btn btn-primary">Academic Report</a>
                @endif
                
              @else
                {{-- <a href="{{url('/student/'.$student->id.'/academic-report')}}" class="btn btn-primary">Academic Report</a> --}}
                <a href="{{url('/student/'.$student->id.'/academic-report')}}" class="btn btn-primary">Academic Report</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="card mt-3">
        <ul class="list-group list-group-flush">
          @if($student->classteacher($student->class_id)->count() != 0)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">Class Teacher</h6>
            <span class="text-primary">
              {{$student->classteacher($student->class_id)->first()->firstname}} 
              {{$student->classteacher($student->class_id)->first()->lastname}}
            </span>
          </li>
          @endif
          @if($student->user->dob != "")
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">Age</h6>
            <span class="text-primary">{{$student->user->age}}</span>
          </li>
          @endif
          @if($student->user->dob != "")
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">Date of Birth</h6>
            <span class="text-primary">{{$student->user->dob_month_day}}</span>
          </li>
          @endif
          @if($student->user->citizenship)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">Citizenship</h6>
            <span class="text-primary">{{$student->user->citizenship}}</span>
          </li>
          @endif
          @if($student->user->state_origin)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">State of Origin</h6>
            <span class="text-primary">{{$student->user->state_origin}}</span>
          </li>
          @endif
          @if($student->user->lga_origin)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="mb-0">LGA of Origin</h6>
            <span class="text-primary">{{$student->user->lga_origin}}</span>
          </li>
          @endif
        </ul>
      </div>
      {{-- @if(Auth::user()->role == "student") --}}
        @if($student->user->dob != "")
          @livewire('student.physical-assessment', ['student_id' => $student->id])
        @endif
      {{-- @endif --}}
    </div>
    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Full Name</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->user->full_name}}
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Email</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->user->email}}
            </div>
          </div>
          
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Guardian Phone</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->user->phone}}
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Student Phone</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->student_phone}}
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Address</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->guardian_address}}
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-info mx-2" target="_blank" href="{{url('/student/profile/'.$student->user_id.'/edit')}}">Edit</a>
              
            </div>
          </div>
        </div>
      </div>

      <div class="row gutters-sm">
        <div class="col-sm-12 mb-3">
            <div class="card mt-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">No of Subjects Offered</h6>
                      <span class="text-primary">13</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Highest Score So far</h6>
                      <span class="text-primary">80% in Mathematics</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Lowest Score So far</h6>
                      <span class="text-primary">50% in English</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Average Score So far</h6>
                      <span class="text-primary">70%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      <h6 class="mb-0">Last Term Performance</h6>
                      <span class="text-primary">89.91%</span>
                    </li>
                </ul>
            </div>
            
        </div>
      </div>



    </div>
  </div>