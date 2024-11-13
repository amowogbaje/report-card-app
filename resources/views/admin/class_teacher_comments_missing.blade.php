<x-admin-layout>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{config('app.name')}}</h2>
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
    <div class='row'>
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
        
        
    </div>
    <div class="row">
            <form class="form-inline" action= "{{route('select-result-session')}}" method="post">
                <div class="form-group my-2">
                    <label class="form-label">Select Session and Term</label>
                    <select class="form-control" id="sessionterm" name="sessionterm">
                        <option value="">Change Session and Term of Results</option>
                        @foreach($termsAndSession as $termSession)
                        <option value="{{$termSession->id}}">{{$termSession->sessionYear->name}} {{$termSession->termYear->name}} Term</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class= "btn btn-success">Go</button>
            </form>
    </div>
    <div class=row>
        <div class="card">
        <h5 class="card-header">List of Students whose class teacher comments were missing (Active Term: {{active_term()->name}} Term)</h5>
        <div class="card-body mb-5">
            <div class="table-responsive">
                <table class="table first">
                    <thead class="bg-light">
                        <tr class="border-0">
                            <th class="border-0">Registration Number</th>
                            <th class="border-0">Class</th>
                            <th class="border-0">Teacher</th>
                            <th class="border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($missing_assessments as $assessment)
                            <tr>
                                
                                <td>{{$assessment->getStudentName($assessment->student_id)->user->username}}</td>
                                <td>{{$assessment->classlevel->name}}</td>
                                <td>{{$assessment->teacher($assessment->class_id)->first()->firstname}} {{$assessment->teacher($assessment->class_id)->first()->lastname}}</td>
                                <td><a target="_blank" href="{{url('/student/'.$assessment->student_id.'/academic-report')}}" class="btn btn-primary">Academic Report</a></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class=row>
        <div class="card">
        <h5 class="card-header">List of Students whose principals comments were missing (Active Term: {{active_term()->name}} Term)</h5>
        <div class="card-body mb-5">
            <div class="table-responsive">
                <table class="table first">
                    <thead class="bg-light">
                        <tr class="border-0">
                            <th class="border-0">Registration Number</th>
                            <th class="border-0">Class</th>
                            <th class="border-0">Teacher</th>
                            <th class="border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($missing_principal_assessments as $assessment)
                            <tr>
                                
                                <td>{{$assessment->getStudentName($assessment->student_id)->user->username}}</td>
                                <td>{{$assessment->classlevel->name}}</td>
                                <td>{{$assessment->teacher($assessment->class_id)->first()->firstname}} {{$assessment->teacher($assessment->class_id)->first()->lastname}}</td>
                                <td><a target="_blank" href="{{url('/student/'.$assessment->student_id.'/academic-report')}}" class="btn btn-primary">Academic Report</a></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</x-admin-layout>