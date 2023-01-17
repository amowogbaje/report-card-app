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
        <h1 class="h3 mb-2 text-gray-800">{{$student->user->full_name}} <a class="btn btn-primary" href="{{url('student/'.$student->id.'/download-result')}}">Download Report Card</a></h1>
        <div class="row">
            <div class="col-md-8 col-sm-12">
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
            <div class="col-md-4 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span>Psychomotic Assessments</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-center">
                                    <th class="text-left">Grade</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </thead>
                                <tfoot class="text-center">
                                    <th class="text-left">Grade</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tfoot>
                                <tr class="text-right">
                                    <td class="text-left">Neatness</td>
                                    <td><input class="custom-control-input" type="radio" name="exampleForm" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="exampleForm" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="exampleForm" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="exampleForm" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="exampleForm" id="radioExample1" /></td>
                                </tr>
                                <tr class="text-right">
                                    <td class="text-left">Punctuality</td>
                                    <td><input class="custom-control-input" type="radio" name="punctuality" id="radioExample1" />j</td>
                                    <td><input class="custom-control-input" type="radio" name="punctuality" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="punctuality" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="punctuality" id="radioExample1" /></td>
                                    <td><input class="custom-control-input" type="radio" name="punctuality" id="radioExample1" /></td>
                                </tr>
                            </table>
                        </div>
                        
                    </form>
                    </div>
            </div>

        </div>



    </div>
</x-admin-layout>