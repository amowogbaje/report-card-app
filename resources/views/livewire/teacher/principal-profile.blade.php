<div class="row gutters-sm">
  <div class="col-md-4 mb-3">
      <div class="card">
          <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <form action="">
                    <h2>Upload Your Profile Pics Here</h2>
                    <label for="profilePics">
                        @if(!empty($user->profile_pics))
                            <img src="{{url('uploads/'.$user->profile_pics)}}" alt="user" class="rounded-circle border border-info" width="110">
                        @else
                            @if($user->gender == 'male')
                                <img src="{{asset('assets/images/male-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                            @elseif($user->gender == 'female')
                                <img src="{{asset('assets/images/female-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                            @else
                                <img src="{{asset('assets/images/female-avatar.png')}}" alt="Teacher" class="rounded-circle p-1 bg-primary" width="110">
                            @endif
                        @endif
                    </label>
                    <input style="display: none" wire:model = "pics" id="profilePics" type="file" accept="image/*"/>
                    <br>
                    <button class="btn btn-info form-control" wire:click.prevent = "uploadPics"><div wire:loading wire:target="uploadPics"><span class="dashboard-spinner spinner-success spinner-xs mr-2"></span></div>Save</button>
                </form>
                <hr>
                <form action="" class="my-5">
                    <h2>Upload Your Signature Here</h2>
                    <label for="signatureUrl">
                        @if(!empty($user->signature_url))
                            <img src="{{url('uploads/'.$user->signature_url)}}" alt="user" class="rounded-0" width="110">
                        @else
                            <img src="{{asset('assets/images/good.jpg')}}" alt="Signature" class="rounded-0 p-1" width="110">
                            
                        @endif
                    </label>
                    <input style="display: none" wire:model = "signature" id="signatureUrl" type="file" accept="image/*"/>
                    <br>
                    <button class="btn btn-info form-control" wire:click.prevent = "uploadSignature"><div wire:loading wire:target="uploadSignature"><span class="dashboard-spinner spinner-success spinner-xs mr-2"></span></div>Save</button>
                </form>
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
                    @if(Auth::user()->role == "admin")
                        <a class="btn btn-info mx-2" target="_blank" href="{{url('change-password')}}"><i class="fas fa-fw fa-unlock"></i>Change Password</a>
                    @endif
                  </div>
              </div>
          </div>
      </div>

      



  </div>
</div>