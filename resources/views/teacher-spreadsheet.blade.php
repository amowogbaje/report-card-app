<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Examify App</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard </a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
        @endif
        @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
        @endif
        <h1 class="h3 mb-2 text-gray-800">{{$subject->name}} Results Spreadsheet</h1>
        

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6>
                    @livewire('teacher.process-subject-result', ['subject_id' => $subject_id, 'class_id' =>$class_id])
                </h6>

                {{-- <h6 class="m-0 font-weight-bold text-primary">
                    <span>Average Score: 60%</span>
                    <span>| Highest Score: 90%</span>
                    <span>| Lowest Score: 40%</span>
                </h6> --}}
            </div>
            <div class="card-body">
                @if(count($students) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th rowspan="2">Full Name</th>
                                <th colspan="4">Assessments</th>
                                <th rowspan="2">Exam</th>
                                <th rowspan="2">Total </th>
                            </tr>
                            <tr>
                                <th>1st CA</th>
                                <th>2nd CA</th>
                                <th>3rd CA</th>
                                <th>TCA</th>
                            </tr>
                        </thead>
                        {{-- <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>200</th>
                                <th>134</th>
                                <th>200</th>
                                <th>400</th>
                                <th>600</th>
                                <th>890</th>
                            </tr>
                        </tfoot> --}}
                        <tbody>
                            <form action="{{url('/teacher/submit/scores')}}" method="post">
                                {{-- <input type="hidden" name="student_id" value="{{$student_id}}"> --}}
                                <input type="hidden" name="subject_id" value="{{$subject_id}}">
                                <input type="hidden" name="class_id" value="{{$class_id}}">
                                @foreach ($students as $student)
                                <tr>
                                    {{-- <input type="hidden" name="student_id[]" value="{{$student->id}}"> --}}
                                    @if($student->subjectResult($subject_id, $student->id)->count() != 0)
                                        <td><a href="teacher-students-profile.html">{{$student->user->full_name}}</a> </td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_1']" value="{{$student->subjectResult($subject_id, $student->id)->first()->ca_1}}"></td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_2']" value="{{$student->subjectResult($subject_id, $student->id)->first()->ca_2}}"></td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_3']" value="{{$student->subjectResult($subject_id, $student->id)->first()->ca_3}}"></td>
                                        <td>{{$student->subjectResult($subject_id, $student->id)->first()->totalca}}</td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['exam']" value="{{$student->subjectResult($subject_id, $student->id)->first()->exam}}"></td>
                                        <td>{{$student->subjectResult($subject_id, $student->id)->first()->total_score}}</td>
                                    {{-- @else 
                                        <td><a href="teacher-students-profile.html">{{$student->user->full_name}}</a> </td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_1']" value="0"></td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_2']" value="0"></td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['ca_3']" value="0"></td>
                                        <td>0</td>
                                        <td><input type="text" class="form-control" name="scores[{{$student->id}}]['exam']" value="0"></td>
                                        <td>0</td> --}}
                                    @endif

                                </tr>
                            @endforeach
                                <tr>
                                    {{ csrf_field() }}
                                    <td><button type="submit" class="btn btn-primary">Submit</button></td>
                                </tr>
                            </form>
                            

                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>