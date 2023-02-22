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
                /* font-size: 1.7em; */
                font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", "serif";
                /* background-image: url({{URL::asset("assets/images/avatar-3.jpg")}}); */
                background-position: center center;
                background-repeat: no-repeat;
                color: black;
    
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
        <table width="2155" style="margin-left: auto; margin-right:auto;">
            <tbody>
                <tr>
                    <td>
                        <img width="300" style="float:left" src="{{url('uploads/'.$schoolInfo->stamp_img_url)}}" alt="" srcset="">
                        @if($student->user->profile_pics != "")
                        <img width="300" style="float:right; border-radius: 10em;" src="{{url('uploads/'.$student->user->profile_pics)}}" alt="" srcset="">
                        @endif
                        <table width="1525" align="center" style="padding-top: 4em; margin-bottom: 8em;">
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
                        </table>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="2200" style="margin-bottom: 8em;">
                            <tr>
                                <td style="vertical-align: top" width="1750">
                                    <table width="1700">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: #ffffff; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 0.3em; border-bottom-right-radius: 0.3em; height: 100px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Student's Performance In Subjects Offered
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
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
                                    <table width="450" align="left">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: #ffffff; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 0.3em; border-bottom-right-radius: 0.3em; height: 100px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Behaviour Assessment
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="450" class="border-line border-decorated">
                                                    <tr class="text-center py-3" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="200" class="text-left text-uppercase px-2 py-2">Behaviour</th>
                                                        <th width="40">5</th>
                                                        <th width="40">4</th>
                                                        <th width="40">3</th>
                                                        <th width="40">2</th>
                                                        <th width="40">1</th>
                                                    </tr>
                                                    @foreach ($behaviourAssessmentsArray as $title => $mark)
                                                        <tr class="text-right py-2">
                                                            <th width = "250" style="color: {{$colorsArray['mainTextColor']}}" class="px-2 text-left text-uppercase">{{camelCase($title)}}</th>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                            @if($mark == $i)
                                                            <td width = "40" style="padding: 10px, 0">
                                                                <img width="20" src="{{URL::asset('assets/libs/svg/check.png')}}" />
                                                            </td>
                                                            @else
                                                            <td style="padding: 20px, 0"></td>
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
                        <table width="2200" class="my-3" style="margin-bottom: 8em;">
                            <tr>
                                <td style="vertical-align: top" width="440">
                                    <table width="400" align="left">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: white; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 1em; border-bottom-right-radius: 1em; height: 80px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Student's Biodata
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" class="border-line border-decorated py-3">
                                                    <tr class="text-center" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="200" class="text-left text-uppercase px-2 py-2">Admission No</th>
                                                        <td width="200">{{$student->user->username}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Session</th>
                                                        <td width="200">{{$current_session->name}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Class</th>
                                                        <td width="200">{{$student->class->shortname}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200"  style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Gender</th>
                                                        <td width="200">{{ucfirst($student->user->gender)}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Age</th>
                                                        <td width="200">{{$physicalAssessmentArray['age']}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Height</th>
                                                        <td width="200">{{$physicalAssessmentArray['height']}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Weight</th>
                                                        <td width="200">{{$physicalAssessmentArray['weight']}}</td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top" width="440">
                                    <table width="400" align="left">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: white; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 1em; border-bottom-right-radius: 1em; height: 80px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Student's Performance
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" class="border-line border-decorated py-3">
                                                    <tr class="text-center" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="300" class="text-left text-uppercase px-2 py-2">Number In Class</th>
                                                        <td width="100">{{$noInClass}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="300" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Mark Obtainable</th>
                                                        <td width="100">{{$academicAssessmentsArray['markObtainable']}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="300" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Mark Obtained</th>
                                                        <td width="100">{{$academicAssessmentsArray['markObtained']}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="300"  style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Student Average Score</th>
                                                        <td width="100">{{$classAssessment->average_score}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="300" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Lowest Score in Class</th>
                                                        <td width="100">{{$classAssessment->lowest_score}}</td>
                                                    </tr>
                                                    <tr class="text-center" >
                                                        <th width="300" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Highest Score in Classs</th>
                                                        <td width="100">{{$classAssessment->highest_score}}</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="300" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Percentage</th>
                                                        <td width="100">{{$academicAssessmentsArray['percentage']}}</td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top" width="440">
                                    <table width="400" align="left">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: #ffffff; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 1em; border-bottom-right-radius: 1em; height: 80px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Skill Assessment
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" class="border-line border-decorated">
                                                    <tr class="text-center py-3" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="200" class="text-left text-uppercase px-2 py-2">Skills</th>
                                                        <th width="40">5</th>
                                                        <th width="40">4</th>
                                                        <th width="40">3</th>
                                                        <th width="40">2</th>
                                                        <th width="40">1</th>
                                                    </tr>
                                                    @foreach ($skillAssessmentsArray as $title => $mark)
                                                        <tr class="text-right py-2">
                                                            <th width = "200" style="color: {{$colorsArray['mainTextColor']}}" class="px-2 text-left text-uppercase">{{camelCase($title)}}</th>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                            @if($mark == $i)
                                                            <td width = "40" style="padding: 10px, 0">
                                                                <img width="20" src="{{URL::asset('assets/libs/svg/check.png')}}" />
                                                            </td>
                                                            @else
                                                            <td style="padding: 20px, 0"></td>
                                                            @endif
                                                            @endfor
                                                            
                                                            
                                                            
                                                        </tr>
                                                    @endforeach
                                                    
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                
                                <td style="vertical-align: top" width="440">
                                    
                                    <table width="400" align="left">
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: white; font-size: 1.5em; padding: 5px; border-bottom-left-radius: 1em; border-bottom-right-radius: 1em; height: 80px; background-color: {{$colorsArray['mainTextColor']}}">
                                                SESSION TIMETABLE
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" class="border-line border-decorated py-3">
                                                    <tr class="text-center" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="200" class="text-left text-uppercase px-2 py-2">Number In Class</th>
                                                        <td width="200">September 19, 2022</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">End of term: </th>
                                                        <td width="200">December 15, 2022</td>
                                                    </tr>

                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">No. of Times School Opened:</th>
                                                        <td width="200">1200</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">No. of Times Present:</th>
                                                        <td width="200">1200</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">No. of Times Absent:</th>
                                                        <td width="200">0</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th width="200" style="color: {{$colorsArray['mainTextColor']}}" class="text-left text-uppercase px-2 py-2">Next Term Begins on: </th>
                                                        <td width="200">Jan 7, 2023</td>
                                                    </tr>
                                                    
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td style="vertical-align: top" width="440">
                                    
                                    <table width="400" align="left" >
                                        <tr>
                                            <td class="text-center text-uppercase" style="color: white; font-size: 1.5em; padding: 10px; border-bottom-left-radius: 1em; border-bottom-right-radius: 1em; height: 80px; background-color: {{$colorsArray['mainTextColor']}}">
                                                Key to Ratings
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold" style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">&nbsp; </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" class="border-line border-decorated py-3">
                                                    <tr class="text-left" bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="50" class="text-center text-uppercase px-2">5</th>
                                                        <td width="350" class="text-uppercase px-2">Maintains an excellent degree of Observable traits</td>
                                                    </tr>
                                                    <tr class="text-left">
                                                        <th width="50" style="color: {{$colorsArray['mainTextColor']}}" class="text-center text-uppercase px-2">4</th>
                                                        <td width="350" class="text-uppercase px-2">Maintains high level of Obsservable traits</td>
                                                    </tr>

                                                    <tr class="text-left">
                                                        <th width="50" style="color: {{$colorsArray['mainTextColor']}}" class="text-center text-uppercase px-2 py-2">3</th>
                                                        <td width="350" class="text-uppercase px-2">Acceptable level of Obsservable traits</td>
                                                    </tr>
                                                    <tr class="text-left">
                                                        <th width="50" style="color: {{$colorsArray['mainTextColor']}}" class="text-center text-uppercase px-2 py-2">2</th>
                                                        <td width="350" class="text-uppercase px-2">Shows minimal regard for Obsservable traits</td>
                                                    </tr>
                                                    <tr class="text-left">
                                                        <th width="50" style="color: {{$colorsArray['mainTextColor']}}" class="text-center text-uppercase px-2 py-2">1</th>
                                                        <td width="350" class="text-uppercase px-2">Shows no regard for Obsservable traits</td>
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
                
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td width="1000">
                                    <table width="900" class="my-3 text-left" style="font-size: 1.7em; border: solid {{$colorsArray['mainTextColor']}}     thin;">
                                        <tr class="px-3">
                                            <th height="40" class="text-left">Class Teacher's Remark:</th>
                                        </tr>
                                        <tr class="px-3">
                                            <td height="40">{{$classTeacherComment}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table width="900" class="my-3 text-left" style="font-size: 1.7em; border: solid {{$colorsArray['mainTextColor']}} thin;">
                                        <tr class="px-3">
                                            <th height="40" class="text-left">Principal's Remark:</th>
                                        </tr>
                                        <tr class="px-3">
                                            <td height="40">{{$principalComment}}</td>
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