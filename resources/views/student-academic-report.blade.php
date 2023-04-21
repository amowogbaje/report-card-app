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
        @if((Auth::user()->role == 'student' && $student->payment_complete == 1) || Auth::user()->role != 'student')
        @livewire('student.download-report', ['student_id' => $student->id])
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                        <h6 class="m-0 font-weight-bold text-primary">
                            <span></span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Subjects</th>
                                        <th colspan="2">1st CA</th>
                                        <th colspan="2">2nd CA</th>
                                        <th colspan="2">3rd CA</th>
                                        <th colspan="2">TCA</th>
                                        <th colspan="2">Exam</th>
                                        <th colspan="2">Total </th>
                                    </tr>
                                    <tr>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Mark Obtained</th>
                                        <th>Total</th>
                                        <th>Grade</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>124</th>
                                        <th>130</th>
                                        <th>123</th>
                                        <th>130</th>
                                        <th>123</th>
                                        <th>130</th>
                                        <th>350</th>
                                        <th>390</th>
                                        <th>900</th>
                                        <th>910</th>
                                        <th>1278</th>
                                        <th>1300</th>
                                    </tr>
                                </tfoot> --}}
                                <tbody>
                                    @foreach ($results as $result)
                                    <tr>
                                        <td>{{$result->subject->name}}</td>
                                        <td>
                                            @if($result->ca_1 != 0)
                                            {{$result->ca_1}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->ca_1 != 0)
                                            10
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->ca_2 != 0)
                                            {{$result->ca_2}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->ca_2 != 0)
                                            10
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->ca_3 != 0)
                                            {{$result->ca_3}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->ca_3 != 0)
                                            10
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->totalca != 0)
                                            {{$result->totalca}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->totalca != 0)
                                            30
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->exam != 0)
                                            {{$result->exam}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->exam != 0)
                                            70
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->total_score != 0)
                                            {{$result->total_score}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($result->total_score != 0)
                                            100
                                            @endif
                                        </td>
                                        <td>{{$result->grade}}</td>
                                        <td>{!!$result->position!!}</td>
                                        
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            <table width="700" class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td height="40" colspan="9">
                                            <h4 class="text-center my-1 text-uppercase">
                                                Summary of Performance</h4>
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>Mark Obtainable</td>
                                        <td>Mark Obtained</td>
                                        <td>Average Score</td>
                                        <td>Lowest Score in Class</td>
                                        <td>Highest Score in Class</td>
                                        <td>Percentage</td>
                                        @if($student->class_stage_id < 7)
                                            <td>Position</td>
                                        @endif


                                    </tr>
                                    <tr class="text-center">
                                        <td>{{$academicAssessmentsArray['markObtainable']}}</td>
                                        <td>{{$academicAssessmentsArray['markObtained']}}</td>
                                        <td>{{$classAssessment->average_score}}</td>
                                        <td>{{$classAssessment->lowest_score}}</td>
                                        <td>{{$classAssessment->highest_score}}</td>
                                        <td>{{$academicAssessmentsArray['percentage']}}</td>
                                        @if($student->class_stage_id < 7)
                                            <td>{{$position_in_class}}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                @if(Auth::user()->role == "student")
                    @if($student->user->dob != "")
                      @livewire('student.physical-assessment', ['student_id' => $student->id])
                    @else
                    <p class="alert-danger">Kindly Update Your Date of Birth to enable Physical Assessment</p>
                    @endif
                @endif
                @if($student->classteacher($student->class_id)->count() != 0)
                    @if(Auth::user()->id == $student->classteacher($student->class_id)->first()->user_id)
                        @livewire('teacher.student-skill-assessment', ['student_id' => $student->id])
                        @livewire('teacher.comments', ['student_id' => $student->id])
                        
                    @endif
                @endif
                @if(Auth::user()->role == "admin")
                    @livewire('principal-comments', ['student_id' => $student->id])
                @endif
            </div>
            <div class="col-md-6 col-sm-12">
                
                @if($student->classteacher($student->class_id)->count() != 0)
                    @if(Auth::user()->id == $student->classteacher($student->class_id)->first()->user_id)
                        @livewire('teacher.student-behaviour-assessment', ['student_id' => $student->id])
                    @endif
                @endif    
            </div>

        </div>
        @else
        @livewire('illegal-entry')
        @endif

    </div>
</x-admin-layout>

