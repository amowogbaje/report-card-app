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
        <h1 class="h3 mb-2 text-gray-800">Students</h1>
        

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    <span>Average Score: 60%</span>
                    <span>| Highest Score: 90%</span>
                    <span>| Lowest Score: 40%</span>
                </h6>
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
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <th>1st CA</th>
                                <th>2nd CA</th>
                                <th>3rd CA</th>
                                <th>TCA</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>200</th>
                                <th>134</th>
                                <th>200</th>
                                <th>400</th>
                                <th>600</th>
                                <th>890</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                @if($student->subjectResult($subject_id, $student->id)->count() != 0)
                                    <td><a href="{{url('/student/profile/'.$student->user_id)}}">{{$student->user->full_name}}</a></td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->ca_1}}</td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->ca_2}}</td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->ca_3}}</td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->totalca}}</td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->exam}}</td>
                                    <td>{{$student->subjectResult($subject_id, $student->id)->first()->total_score}}</td>
                                    <td>View All</td>
                                @endif

                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>