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
                                        <td>{{$result->ca_1}}</td>
                                        <td>10</td>
                                        <td>{{$result->ca_2}}</td>
                                        <td>10</td>
                                        <td>{{$result->ca_3}}</td>
                                        <td>10</td>
                                        <td>{{$result->totalca}}</td>
                                        <td>30</td>
                                        <td>{{$result->exam}}</td>
                                        <td>70</td>
                                        <td>{{$result->total_score}}</td>
                                        <td>100</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                
                @if($student->classteacher($student->class_id)->count() != 0)
                    @if(Auth::user()->id == $student->classteacher($student->class_id)->first()->user_id)
                        @livewire('teacher.student-skill-assessment', ['student_id' => $student->id])
                        @livewire('teacher.comments', ['student_id' => $student->id])
                        
                    @endif
                @endif
                {{-- @if(Auth::user()->role == "admin") --}}
                    @livewire('principal-comments', ['student_id' => $student->id])
                {{-- @endif --}}
            </div>
            <div class="col-md-6 col-sm-12">
                
                {{-- @if($student->classteacher($student->class_id)->count() != 0) --}}
                    {{-- @if(Auth::user()->id == $student->classteacher($student->class_id)->first()->user_id) --}}
                        @livewire('teacher.student-behaviour-assessment', ['student_id' => $student->id])
                    {{-- @endif --}}
                {{-- @endif --}}    
            </div>

        </div>

    </div>
</x-admin-layout>
