<div class="row gutters-sm">
    <div class="col-md-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-column align-items-center text-center">
            <form action="">
              <label for="profilePics">
                @if(!empty($student->user->profile_pics))
                  <img src="{{url('uploads/'.$student->user->profile_pics)}}" alt="user" class="rounded-circle border border-info" width="110">
                @else
                  @if($student->user->gender == 'male')
                    <img src="{{asset('assets/images/male-avatar.png')}}" alt="Student" class="rounded-circle p-1 bg-primary" width="110">
                  @elseif($student->user->gender == 'female')
                    <img src="{{asset('assets/images/female-avatar.png')}}" alt="Student" class="rounded-circle p-1 bg-primary" width="110">
                  @endif
                @endif
              </label>
              <input style="display: none" wire:model = "pics" id="profilePics" type="file" accept="image/*"/>
              <br>
              <button class="btn btn-info form-control" wire:click.prevent = "uploadPics">Save</button>
            </form>
            
            <div class="mt-3">
              <h4>{{$student->user->full_name}}</h4>
              <p class="text-primary mb-1">{{$student->class->shortname}} Student</p>
              <p class="text-muted font-size-sm">{{$student->user->address}}</p>
              @if(Auth::user()->role == 'student')
                @if($student->payment_complete)
                  <a href="{{url('/student/'.$student->id.'/academic-report')}}" class="btn btn-primary">Academic Report</a>
                @else
                  <a href="javascript::void()" data-toggle="modal" data-target="#enter_acess_code_modal" class="btn btn-primary" >Academic Report</a>
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
      @if(Auth::user()->role == "student")
        @if($student->user->dob != "")
          @livewire('student.physical-assessment', ['student_id' => $student->id])
        @endif
      @endif
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
          @if($student->payment_token_available)
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Payment Verification Code</h6>
            </div>
            <div class="col-sm-9 text-primary">
              {{$student->payment_codes->payment_verification_code}}
            </div>
          </div>
          @endif
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-info mx-2" target="_blank" href="{{url('/student/profile/'.$student->user_id.'/edit')}}">Edit</a>
              @if(Auth::user()->role == "admin")
              <a class="btn btn-info mx-2" target="_blank" href="{{url('admin/change-password/'.$student->user_id)}}"><i class="fas fa-fw fa-unlock"></i>Change Password</a>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="row gutters-sm">
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
      </div> --}}



    </div>
    <div wire:ignore.self class="modal fade" id="enter_acess_code_modal" tabindex="-1" role="dialog"
    aria-labelledby="enterAcessClassModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="assign_teacher_topic" class="modal-title">Enter Payment Verification Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                      <div class="form-group mb-2">
                        <input type="text" class="form-control @error('payment_verification_code') is-invalid @enderror" id="phone" placeholder="Enter Payment Verification Code Here" wire:model.defer="payment_verification_code">
                        @error('payment_verification_code') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button wire:click="verifyPayment()" class="btn btn-primary">Verify Payment</button>
                </div>
            </div>
        </div>
    </div>
  </div>