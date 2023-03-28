<div class="card">
    <h5 class="card-header">Subject Teacher Allocation List</h5>
    @if($noOfSubjectClassesAssigned != $noOfSubjectsPerClass)
    <h5 class="card-header text-secondary">Note: Allocation of Subject of Subjects Must be Complete before Activities can Start</h5>
    <h5 class="card-header">{{$noOfSubjectClassesAssigned}} out of {{$noOfSubjectsPerClass}}</h5>
    @endif
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                    <tr class="border-0">
                        {{-- <th class="border-0">Name</th> --}}
                        <th class="border-0">Teacher</th>
                        <th class="border-0">Subjects</th>
                        <th class="border-0">Class</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($teachersubjects) > 0)
                        @foreach ($teachersubjects as $teachersubject)
                            <tr>
                                <td>{{$teachersubject->user($teachersubject->teacher->user_id)->fullname}}</td>
                                <td>{{$teachersubject->subject->name}}</td>
                                <td>{{$teachersubject->class->shortname}}</td>
                                
                                
                                
                            </tr> 
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

