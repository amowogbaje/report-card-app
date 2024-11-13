<div class="row">
    <div class="col-lg-4 col-sm-12">
        <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <form>
                    <label for="stamp_img_file">
                        <img src="" alt="user" class="d-none rounded-circle border border-3 border-info" width="110" id = 'stamp_img_url_hidden'>
                        @if(!empty($schoolInfo->stamp_img_url))
                            <img src="{{url('uploads/'.$schoolInfo->stamp_img_url)}}" alt="user" class="rounded-circle border border-3 border-info" width="110" id = 'stamp_img_url'>
                        @else
                            <img src="{{asset('assets/images/male-avatar.png')}}" alt="Student" class="rounded-circle p-1 bg-primary" width="110" id = 'stamp_img_url'>
                        @endif
                    </label>
                    <input style="display: none" wire:model = "pics" id="stamp_img_file" type="file" accept="image/*"/>
                    
                    <input type = "hidden"  id= "school_colors" wire:model= "school_colors" />
                    
                    <br>
                    <button class="btn btn-info form-control" wire:click.prevent = "uploadPics" @if($schoolInfo->school_colors) style="background-color: {{$schoolInfo->school_colors}}" @endif>Save</button>
                </form>
                
                
                <div class="mt-3">
                  <h4>{{$schoolInfo->name}}</h4>
                  <p class="text-muted font-size-sm">{{$schoolInfo->address}}</p>
                  {{-- <a href="{{ url('/')}}" class="btn btn-primary">Academic Report</a> --}}
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group mb-2">
                                <label for="">School Name</label>
                                <input type="text" wire:model.defer="name" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group mb-2">
                                <label for="">School Code Name</label>
                                <input type="text" wire:model.defer="codename" {{$readonly}} class="form-control">
                                @error('codename') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group mb-2">
                                <label for="">School Type</label>
                                <select class="form-control @error('type') is-invalid @enderror" {{$readonly}} wire:model ='type'>
                                    <option value="preparatory">Preparatory</option>
                                    <option value="secondary">Secondary</option>
                                </select>
                                @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                                
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group mb-2">
                                <label for="">School Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="" cols="30" rows="10" wire:model.defer="address"></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button wire:click.prevent="update()" class="btn btn-primary">Update Details</button>
            </div>
        </div>
        
    </div>
</div>