<div class="row gutters-sm">
  <div class="col-md-4 mb-3">
      <div class="card">
          <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
            @if(!empty($teacher->user->profile_pics))
                <img src="{{$teacher->user->profile_pics}}" alt="user" class="rounded" width="110">
            @else
                @if($teacher->user->gender == 'male')
                <img src="{{asset('assets/images/male-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                @elseif($teacher->user->gender == 'female')
                <img src="{{asset('assets/images/female-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                @endif
            @endif
                  <div class="mt-3">
                      <h4>{{$teacher->user->full_name}}</h4>
                      @if($teacher->class_id != "")
                      <p class="text-primary mb-1">{{$teacher->class->shortname}} Class Teacher</p>
                      @endif
                      @if($teacher->user->address != "")
                      <p class="text-muted font-size-sm">{{$teacher->user->address}}</p>
                      @endif
                      {{-- @if($teacher->class_id == "")
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
              @if($teacher->user->dob != "")
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <h6 class="mb-0">Date of Birth</h6>
                  <span class="text-primary">{{$teacher->user->dob_month_day}}</span>
              </li>
              @endif
              @if($teacher->user->citizenship)
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <h6 class="mb-0">Citizenship</h6>
                  <span class="text-primary">{{$teacher->user->citizenship}}</span>
              </li>
              @endif
              @if($teacher->user->state_origin)
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <h6 class="mb-0">State of Origin</h6>
                  <span class="text-primary">{{$teacher->user->state_origin}}</span>
              </li>
              @endif
              @if($teacher->user->lga_origin)
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <h6 class="mb-0">LGA of Origin</h6>
                  <span class="text-primary">{{$teacher->user->lga_origin}}</span>
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
                      {{$teacher->user->full_name}}
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                  </div>
                  <div class="col-sm-9 text-primary">
                      {{$teacher->user->email}}
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                  </div>
                  <div class="col-sm-9 text-primary">
                      {{$teacher->user->phone}}
                  </div>
              </div>
              @if($teacher->user->address != '')
              <hr>
              <div class="row">
                  <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                  </div>
                  <div class="col-sm-9 text-primary">
                      {{$teacher->user->address}}
                  </div>
              </div>
              @endif
              <hr>
              <div class="row">
                  <div class="col-sm-12">
                      <a class="btn btn-info " target="_blank"
                          href="{{url('/teacher/profile/'.$teacher->user_id.'/edit')}}">Edit</a>
                  </div>
              </div>
          </div>
      </div>

      <div class="row gutters-sm">
          <div class="col-sm-12 mb-3">
              <div class="card mt-0">
                  <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                          <h6 class="mb-0">No of Subjects Offered X Classes</h6>
                          <span class="text-primary">{{$noOfSubjects}}</span>
                      </li>
                      @foreach ($subjectAndClasses as $subjectAndClass)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">{{$subjectAndClass->class->shortname}} {{$subjectAndClass->subject->name}}</h6>
                            @if(Auth::user()->role == 'admin')
                                <span class="text-primary"><a href="{{url('/admin/class/'.$subjectAndClass->class->id.'/subject/'.$subjectAndClass->subject->id.'/spreadsheet')}}" class="text-primary"><i class="fa fa-eye"></i></a></span>
                            @endif
                        </li>
                      @endforeach
                      
                  </ul>
              </div>

          </div>
      </div>



  </div>

  <div wire:ignore.self class="modal fade" id="assign_teacher_to_class_modal" tabindex="-1" role="dialog"
      aria-labelledby="assignTeacherToClassModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Assign Teacher</h5>
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
                              @foreach ($classlevels as $class)
                              <option value="{{$class->id}}" @selected(true)>{{$class->name}} {{$class->alias}}</option>
                              @endforeach
                          </select>
                          @error('gender') <span class="text-danger">{{ $message }}</span>@enderror
                      </div>


                  </form>

              </div>
              <div class="modal-footer">
                  <button wire:click="pick">Like Post</button>
                  <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                  <button wire:click="assignClass()" class="btn btn-primary">Save changes</button>
              </div>
          </div>
      </div>
  </div>
</div>