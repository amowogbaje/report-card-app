<div>
    <div class="row gutter-sm">
        <div class="col-sm-12 mx-auto">
            <div class="card">
                <h5 class="card-header text-center"> {{$subject->name}} Registration Form </h5>
                <h5 class="card-header text-center">List of All Students in  {{$classLevel->shortname}}</h5>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">Fullname</th>
                                    <th class="border-0">Admission No</th>
                                    <th class="border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{$student->user->fullname}}</td>
                                        <td>{{$student->user->username}}</td>
                                        <td>
                                            @if($subject->studentRegistered($student->id, $subject->id) == 0)
                                            <form>
                                                <input type="checkbox" value="{{$student->id}}" wire:model= "selectedStudents">
                                            </form>
                                            @else
                                                <a wire:click="confirmDelete({{$student->id}})"><i class="fa fa-trash"></i></a>
                                            @endif
                                            
                                        </td>
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row gutter-sm">
        <div class="col-sm-12 mx-auto">
            <button class="btn btn-success" wire:click="store">Submit</button>
        </div>
    </div>
</div>