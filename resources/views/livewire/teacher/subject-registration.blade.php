<div>
    <form action={{route('register-student-for-subject')}} method='post'>
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
                                        <th class="border-0">
                                            <input class="form-check-input " type="checkbox" id="select-unselect" onclick= "selectUnselect()">
                                            <label class="form-check-label" id="select-unselect-text" for="select-unselect">Select All</label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{$student->user->fullname}}</td>
                                            <td>{{$student->user->username}}</td>
                                            <td>
                                                @if($subject->studentRegistered($student->id, $subject->id) == 0)
                                                
                                                    <div class="form-check">
                                                        <input class="form-check-input select-subjects-group" type="checkbox" value="{{$student->id}}" id="student-{{$student->id}}" name= "selectedStudents[]">
                                                        <label class="form-check-label" for="student-{{$student->id}}">
                                                            Register
                                                        </label>
                                                    </div>
                                                
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
                <input type="hidden" name="class_id" value="{{$class_id}}"/>
                <input type="hidden" name="subject_id" value="{{$subject_id}}"/>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>