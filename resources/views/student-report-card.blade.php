<!doctype html>
<html lang="en-US">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$student->user->fullname}}  Report Card</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", "serif";
                /* background-image: url({{URL::asset("assets/images/avatar-3.jpg")}}); */
                background-position: center center;
                background-repeat: no-repeat;
    
            }
        </style>
        <!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
        <script>var __adobewebfontsappname__ = "dreamweaver"</script>
        <script src="http://use.edgefonts.net/source-sans-pro:n2:default.js" type="text/javascript"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      
      
    <![endif]-->
    <link rel="stylesheet" href="{{URL::asset('assets/libs/css/reportCard.css') }}">
    
    </head>

    <body>
        <table width="2155" >
            <tbody>
                <tr>
                    <td>
                        <h4 class="fs-5 my-2 text-center">{{$schoolInfo->name}}</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 class="fs-4 my-2 text-center">{{$student->class_stage->name}} End of {{$current_term->name}} Report</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="2200">
                            <tbody>
                                <tr>
                                    <td width="900">
                                        <table width="600" class="border-line">
                                            <tbody>
                                                <tr>
                                                    <td height="40" colspan="10">
                                                        <h4 class="text-center my-1 text-uppercase">
                                                            Student's Particular</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="40" colspan="10">
                                                        <h4 class="my-1 text-uppercase">Name: {{$student->user->fullname}}</h4>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td height="40">Year Admitted</td>
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
                                                <tr class="text-center">
                                                    <td height="40"></td>
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
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="400"></td>
                                    <td width="800">
                                        <table width="700" align="right">
                                            <tbody>
                                                <tr>
                                                    <td width="700">
                                                        <table width="700"  class="border-line">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="40" colspan="8">
                                                                        <h4 class="text-center my-1 text-uppercase">
                                                                            Summary of Performance</h4>
                                                                    </td>
                                                                </tr>
                                                                <tr class="text-center">
                                                                    <td height="40">No. In Class</td>
                                                                    <td>Mark Obtainable</td>
                                                                    <td>Mark Obtained</td>
                                                                    <td>Average Score</td>
                                                                    <td>Lowest Score in Class</td>
                                                                    <td>Highest Score in Class</td>
                                                                    <td>Percentage</td>
                                                                    <td>Position</td>


                                                                </tr>
                                                                <tr class="text-center">
                                                                    <td height="40" >{{$noInClass}}</td>
                                                                    <td>{{$academicAssessmentsArray['markObtainable']}}</td>
                                                                    <td>{{$academicAssessmentsArray['markObtained']}}</td>
                                                                    <td>{{$classAssessment->average_score}}</td>
                                                                    <td>{{$classAssessment->lowest_score}}</td>
                                                                    <td>{{$classAssessment->highest_score}}</td>
                                                                    <td>{{$academicAssessmentsArray['percentage']}}</td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="2200">
                            <tr>
                                <td style="vertical-align: top" width="1750">
                                    <table width="1750">
                                        <tr class="text-uppercase text-center">
                                            <td>Student's Performance In Subjects Offered</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width = "1700" class="border-line">
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
                                                            <th>Mark Obtainable</th>
                                                            <th>Mark Obtained</th>
                                                            <th>Mark Obtainable</th>
                                                            <th>Mark Obtained</th>
                                                            <th>Mark Obtainable</th>
                                                            <th>Mark Obtained</th>
                                                            <th>Mark Obtainable</th>
                                                            <th>Mark Obtained</th>
                                                            <th>Mark Obtainable</th>
                                                            <th>Mark Obtained</th>
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
                                                        <tr class="text-center">
                                                            <td width="200" height="40" class="text-left py-3 px-2">{{$result->subject->name}}</td>
                                                            <td >10</td>
                                                            <td>{{$result->ca_1}}</td>
                                                            <td>10</td>
                                                            <td>{{$result->ca_2}}</td>
                                                            <td>10</td>
                                                            <td>{{$result->ca_3}}</td>
                                                            <td>70</td>
                                                            <td>{{$result->exam}}</td>
                                                            <td>100</td>
                                                            <td>{{$result->total_score}}</td>
                                                            <td>{{$result->cumulative_percentage}}</td>
                                                            <td>{{$result->average_score}}</td>
                                                            <td>{{$result->highest_score}}</td>
                                                            <td>{{$result->lowest_score}}</td>
                                                            <td>{{$result->grade}}</td>
                                                            <td>{!! $result->position !!}</td>
                                                            <td>
                                                                {{$result->subjectTeacher($result->subject->id, $result->classlevel->id)->firstname}} 
                                                                {{$result->subjectTeacher($result->subject->id, $result->classlevel->id)->lastname}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top" width="450">
                                    <table width="300" align="right">
                                        <tr class="text-center text-uppercase">
                                            <td>Skills and Behaviour</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="300" class="border-line">
                                                    <tr class="text-center">
                                                        <th class="text-left px-2 py-2">Skills</th>
                                                        <th>5</th>
                                                        <th>4</th>
                                                        <th>3</th>
                                                        <th>2</th>
                                                        <th>1</th>
                                                    </tr>
                                                    @foreach ($skillAssessmentsArray as $title => $mark)
                                                        <tr class="text-right">
                                                            <td class="px-2 text-left">{{$title}}</td>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                            @if($mark == $i)
                                                            <td style="padding: 10px, 0">
                                                                <img width="20" src="{{URL::asset('assets/libs/svg/check.png')}}" />
                                                            </td>
                                                            @else
                                                            <td style="padding: 20px, 0"></td>
                                                            @endif
                                                            @endfor
                                                            
                                                            
                                                            
                                                        </tr>
                                                    @endforeach

                                                    <tr class="text-center">
                                                        <th class="px-2 py-2 text-left">Behaviour</th>
                                                        <th>5</th>
                                                        <th>4</th>
                                                        <th>3</th>
                                                        <th>2</th>
                                                        <th>1</th>
                                                    </tr>
                                                    @foreach ($behaviourAssessmentsArray as $title => $mark)
                                                        <tr class="text-right">
                                                            <td class="px-2 text-left">{{$title}}</td>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                            @if($mark == $i)
                                                            <td style="padding: 10px, 0">
                                                                <img width="20" src="{{URL::asset('assets/libs/svg/check.png')}}" alt="" srcset="">
                                                            </td>
                                                            @else
                                                            <td  style="padding: 20px, 0"></td>
                                                            @endif
                                                            @endfor
                                                            
                                                            
                                                            
                                                        </tr>
                                                    @endforeach
                                                    


                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td width="1000">
                                    <table>
                                        <tr><td height="50"></td></tr>
                                    </table>
                                    <table width="900" class="my-3 text-left border-rect">
                                        <tr class="px-3">
                                            <th height="40" class="text-left">Class Teacher's Remark:</th>
                                        </tr>
                                        <tr class="px-3">
                                            <td height="40">{{$classTeacherComment}}</td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr><td height="50"></td></tr>
                                    </table>
                                    <table width="900" class="my-3 text-left border-rect">
                                        <tr class="px-3">
                                            <th height="40" class="text-left">Principal's Remark:</th>
                                        </tr>
                                        <tr class="px-3">
                                            <td height="40">{{$principalComment}}</td>
                                        </tr>
                                    </table>

                                </td>
                                <td width="500">
                                    <table width="500" class="border-line py-3 px-2">
                                        <tr>
                                            <th class="text-left">Beginning of Term: <span class="underline ">September
                                                    19, 2022</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">End of term: <span class="underline">1200</span></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. of Times School Opened: <span
                                                    class="underline">1200</span></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. of Times Present: <span
                                                    class="underline">1200</span></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. of Times Absent: <span
                                                    class="underline">1200</span></th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Next Term Begins on: <span
                                                    class="underline">1200</span></th>
                                        </tr>
                                    </table>
                                </td>
                                <td width="700" >
                                    <table width="500"align="right" class="my-3 py-1 px-2">
                                        <tr class="text-center">
                                            <td>Keys to Ratings</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <table width="500" class="border-line px-3">
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
                    </td>
                </tr>
            </tbody>
        </table>

        


    </body>

</html>