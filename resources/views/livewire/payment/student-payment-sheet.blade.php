<div>
    <div class="row gutter-sm">
        <div class="col-sm-12 mx-auto">
            <div class="card">
                <h5 class="card-header text-center">
                    <span>Payment Sheet for All Students</span>
                    {{-- <a class="btn btn-secondary" href="#" wire:click = "generateOtp">Generate Token For All Students</a> --}}
                </h5>
                
            </div>
        </div>
        
    </div>
    @foreach ($allStudents as $key => $classStudents)
    <div class="row gutter-sm">
        <div class="col-sm-12 mx-auto">
            <div class="card">
                <h5 class="card-header text-center">{{$classes[$key]}} {{count($classStudents)}}</h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Firstname</th>
                                    <th class="border-0">Lastname</th>
                                    <th class="border-0">Registration No</th>
                                    <th class="border-0">Guardian Phone</th>
                                    <th class="border-0">Class</th>
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($classStudents) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No data here, fill in some details </td>
                                </tr>
                                @else
                                    @foreach ($classStudents as $student)
                                        <tr>
                                            <td>{{$student->user->firstname}}</td>
                                            <td>{{$student->user->lastname}}</td>
                                            <td>{{$student->user->username}}</td>
                                            <td>{{$student->guardian_phone}}</td>
                                            <td>{{$student->class->shortname}}</td>
                                            
                                            <td>
                                                @if($student->payment_token_available == 0)
                                                <form>
                                                    <button class="btn btn-sm btn-info text-dark" wire:click.prevent= "confirmPayment({{$student->id}})">Confirm Payment</button>
                                                </form>
                                                @else
                                                    <a><i class="fa fa-check"></i></a>
                                                    <button class="btn btn-sm btn-info text-dark" wire:click.prevent= "unconfirmPayment({{$student->id}})"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr> 
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div> 
    @endforeach
    
</div>