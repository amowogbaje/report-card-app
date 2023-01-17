
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{URL::asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('assets/libs/css/reportCard.css') }}">
    <title>{{config('app.name')}}</title>
    <style>
        body {
            width: 2000px;
            background-color: white;
        }

        .underline {
            text-decoration: underline;
        }
        .vertical-text th {
            
            /* text-orientation: sideways-right;
            writing-mode: vertical-lr */
        }
        /* table, caption, tbody, tfoot, thead, tr, th, td {
            vertical-align: baseline
        } */
        
    </style>
</head>

<body>
    

    <table style="background-color: white; text-align: center;" class="table" width="1800px" cellspacing="0">
        <tr>
            <h1 class="display-4 text-uppercase text-center text-dark">The Ambassador College</h1>
            <h1 class="display-6 text-uppercase text-center">Junior Secondary End of First Term</h1>
        </tr>
    </table>
    <br>
    @if($resultIsReady)
        <table style="background-color: white; text-align: center;" class="table" width="1800px" cellspacing="0">
            <tr class="text-uppercase" style="width: 2000px; border:none">
                <td style="border:none">
                    <table style="width: 600px" class="table-bordered">
                        <tr>
                            <th colspan="10">Student's Particular</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-left">Name: <span class="text-underline">{{$student->user->fullname}}</span></th>
                        </tr>
                        <tr>
                            <td>Year Admitted</td>
                            <td>Admission No</td>
                            <td>File No</td>
                            <td>Session</td>
                            <td>Class</td>
                            <td>House</td>
                            <td>Sex</td>
                            <td>Age</td>
                            <td>Height</td>
                            <td>Weight</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$current_session->name}}</td>
                            <td>{{$student->class->shortname}}</td>
                            <td></td>
                            <td>{{ucfirst($student->user->gender)}}</td>
                            <td>{{$physicalAssessmentArray['age']}}</td>
                            <td>{{$physicalAssessmentArray['height']}}</td>
                            <td>{{$physicalAssessmentArray['weight']}}</td>
                        </tr>
                    </table>
                </td>
                <td style="border:none" style="width: 400px">
                    <img src="{{URL::asset('assets/images/avatar-1.jpg')}}" alt="">
                </td>
                <td style="border:none">
                    <table style="width: 700px" class="table-bordered">
                        <tr>
                            <th colspan="9">Summary of Performance</th>
                        </tr>
                        <tr>
                            <td>No. In Class</td>
                            <td>Mark Obtainable</td>
                            <td>Mark Obtained</td>
                            <td>Average Score</td>
                            <td>Lowest Score in Class</td>
                            <td>Highest Score in Class</td>
                            <td>Percentage</td>
                            <td>Position</td>

                        </tr>
                        <tr>
                            <td>{{$noInClass}}</td>
                            <td>{{$academicAssessmentsArray['markObtainable']}}</td>
                            <td>{{$academicAssessmentsArray['markObtained']}}</td>
                            <td>{{$classAssessment->average_score}}</td>
                            <td>{{$classAssessment->lowest_score}}</td>
                            <td>{{$classAssessment->highest_score}}</td>
                            <td>{{$academicAssessmentsArray['percentage']}}</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table style="background-color: white; text-align: center;" class="table" width="1800px" cellspacing="0">
            <tr style="width: 100%;">
                <td style=" border:none" colspan="19" class="text-uppercase h3 fw-bolder">Student's Performance In Subjects Offered</td>
            </tr>
            <tr style="width:100%;" class="align-top">
                <td style="width: 1300px;  border:none">
                    <table class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr class="text-uppercase">
                                <th rowspan="2"></th>
                                <th colspan="6">Continous Assessment</th>
                                <th colspan="2" rowspan="2">Term's Exam</th>
                                <th colspan="2" rowspan="2">Total </th>
                                <th colspan="7" rowspan="2">Summary of Term's Work </th>
                            </tr>
                            <tr class="text-uppercase">
                                
                                <th colspan="2">1st Test</th>
                                <th colspan="2">2nd Test</th>
                                <th colspan="2">3rd Test</th>
                            </tr>
                            <tr class="text-uppercase">
                                <th>Subjects</th>
                                <th>Mark Obtained</th>
                                <th>Mark Obtainable</th>
                                <th>Mark Obtained</th>
                                <th>Mark Obtainable</th>
                                <th>Mark Obtained</th>
                                <th>Mark Obtainable</th>
                                <th>Mark Obtained</th>
                                <th>Mark Obtainable</th>
                                <th>Mark Obtained</th>
                                <th>Mark Obtainable</th>
                                <th>Percentage Score </th>
                                <th>Class Average </th>
                                <th>Class Highest Mark </th>
                                <th>Class Lowest Mark </th>
                                <th>Grade </th>
                                <th>Position</th>
                                <th>Subject Teacher's Name</th>
                            </tr>
                        </thead>
                        
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
                                <td>{{$result->exam}}</td>
                                <td>70</td>
                                <td>{{$result->total_score}}</td>
                                <td>100</td>
                                <td>{{$result->exam}}</td>
                                <td>{{$result->average_score}}</td>
                                <td>{{$result->highest_score}}</td>
                                <td>{{$result->lowest_score}}</td>
                                <td>{{$result->grade}}</td>
                                <td>{{$result->position}}</td>
                                <td>
                                    {{$result->subjectTeacher($result->subject->id, $result->classlevel->id)->firstname}} 
                                    {{$result->subjectTeacher($result->subject->id, $result->classlevel->id)->lastname}}
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </td>
                <td id="pyschomotor-cell" class="align-top" style="width: 500px; border:none">
                    {{-- SKILLS AND BEHAVIOURS --}}
                    <table style="width: 100%;">
                        <tr style="border: none">
                            <td style="border: none" colspan="6" class="h5 text-uppercase fw-bold">Skills and Behaviour</td>
                        </tr>
                        <tr class="text-center">
                            <td style="border: none">
                                <table class="table table-bordered" style="width: 100%;">
                                    <tr class="text-center">
                                        <th class="text-left">Skills</th>
                                        <th>5</th>
                                        <th>4</th>
                                        <th>3</th>
                                        <th>2</th>
                                        <th>1</th>
                                    </tr>
                                    @foreach ($skillAssessmentsArray as $title => $mark)
                                        <tr class="text-right">
                                            <td class="text-left">{{$title}}</td>
                                            @for ($i = 5; $i >= 1; $i--)
                                            @if($mark == $i)
                                            <td>
                                                <div style="background-color: #000; width: 100%; padding:5px; margin:0"></div>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                            @endfor
                                            
                                            
                                            
                                        </tr>
                                    @endforeach
                                    
                                    <tr class="text-center">
                                        <th class="text-left">Behaviour</th>
                                        <th>5</th>
                                        <th>4</th>
                                        <th>3</th>
                                        <th>2</th>
                                        <th>1</th>
                                    </tr>
                                    @foreach ($behaviourAssessmentsArray as $title => $mark)
                                        <tr class="text-right">
                                            <td class="text-left">{{$title}}</td>
                                            @for ($i = 5; $i >= 1; $i--)
                                            @if($mark == $i)
                                            <td>
                                                <div style="background-color: #000; width: 100%; padding:5px; margin:0"></div>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                            @endfor
                                            
                                            
                                            
                                        </tr>
                                    @endforeach

                                </table>
                            </td>
                        </tr>
                    </table>

                    {{-- KEYS TO RATING --}}
                    <table style="width: 100%;">
                        <tr>
                            <td style="border: none" colspan="2" class="h5 text-uppercase fw-bold">Keys to Ratings</td>
                        </tr>
                        <tr class="text-center">
                            <td style="border: none">
                                <table class="table table-bordered" style="width: 100%;">
                                    <tr>
                                        <td>5</td>
                                        <td>Maintains an excellent degree of Observable traits</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Maintains high level of Obsservable traits</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Acceptable level of Obsservable traits</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Shows minimal regard for Obsservable traits</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Shows no regard for Obsservable traits</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    
                </td>
            </tr>
                        
        </table>
        <br>
        <table style="background-color: white; text-align: center;" class="table" width="1300px" cellspacing="0">
            <tr style="width: 1300px">
                <td style="border:none" width="720"  class="mx-2">
                    <table width="700" style="border: solid #000 thin">
                        <tr>
                            <th style="border: none" class="text-left text-uppercase h5">Class Teacher's Remark:</th>
                        </tr>
                        <tr>
                            <td style="border: none" class="text-left h5">He is a good boy</td>
                        </tr>
                    </table>
                    <br><br>
                    <table width="700" style="border: solid #000 thin">
                        <tr>
                            <th style="border: none" class="text-left text-uppercase h5">Principal's Remark:</th>
                        </tr>
                        <tr>
                            <td style="border: none" class="text-left h5">He is a good boy</td>
                        </tr>
                    </table>
                </td>
                <td width="500" style="border:none">
                    <table class="table table-bordered text-uppercase" style="width: 500px;">
                        <tr>
                            <th class="text-left">Beginning of Term: <span class="underline">September 19, 2022</span></th>
                        </tr>
                        <tr>
                            <th class="text-left">End of term: <span class="underline">1200</span></th>
                        </tr>
                        <tr>
                            <th class="text-left">No. of Times School Opened: <span class="underline">1200</span></th>
                        </tr>
                        <tr>
                            <th class="text-left">No. of Times Present: <span class="underline">1200</span></th>
                        </tr>
                        <tr >
                            <th class="text-left">No. of Times Absent: <span class="underline">1200</span></th>
                        </tr>
                        <tr>
                            <th class="text-left">Next Term Begins on: <span class="underline">1200</span></th>
                        </tr>
                    </table>
                </td>
                
            </tr>
        </table>
    @else
        <span>Your Report Card Is Not Ready because you have not completed all the assessments</span>
    @endif
    
    
    <script src="{{URL::asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
</body>
 
</html>