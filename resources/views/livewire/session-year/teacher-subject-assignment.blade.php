<div class="card">
    <h5 class="card-header">Subject Teacher Allocation List</h5>
    <h5 class="card-header">{{$noOfSubjectClassesAssigned}} subjects with classes allocated.</h5>
    @if(count($teachersubjects) == 0)
    <h5 class="card-header text-secondary">Note: Allocation of Subject of Subjects Must be have been done half way before Activities can Start</h5>
    @endif
    
    <div class="card-body px-3">
        <div class="table-responsive">
            <table class="table first">
                <thead class="bg-light">
                    <tr class="border-0">
                        {{-- <th class="border-0">Name</th> --}}
                        <th class="border-0">Subjects</th>
                        <th class="border-0">Teacher</th>
                        <th class="border-0">Class</th>
                        <!--<th class="border-0">Action</th>-->
                    </tr>
                </thead>
                <tbody>
                    @if(count($teachersubjects) > 0)
                    
                        @foreach ($teachersubjects as $teachersubject)
                            <tr>
                                <td>{{$teachersubject->subject->name}}</td>
                                <td>{{$teachersubject->user($teachersubject->teacher->user_id)->fullname}}</td>
                                <td>{{$teachersubject->class->shortname}}</td>
                                <!--<td><a class="btn btn-primary" href="#" wire:click="delete({{$teachersubject->id}})"><i class="fa fa-trash"></i> Delete</a></td>-->
                                
                                
                                
                            </tr> 
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
</div>


