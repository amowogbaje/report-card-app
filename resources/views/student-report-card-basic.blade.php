<!doctype html>
<html lang="en-US">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$student->user->fullname}} Report Card</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                /* font-size: 1.7em; */
                font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", "serif";
                background-image: url("{{url('uploads/'.$schoolInfo->stamp_img_url)}}");
                background-position: center center;
                background-repeat: no-repeat;
                background-size: 40em;
                color: black;
                opacity: 0.2em;

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
        <style>
            .border-line td,
            .border-line th {
                border: solid {
                        {
                        $colorsArray['mainTextColor']
                    }
                }

                thin;
                margin: 0px;


            }

            .schoolTitleBox td {
                text-align: center;
                vertical-align: middle;
                position: relative;
            }

            .schoolTitleBox td img {
                vertical-align: middle;
                display: inline-block;
            }

            .schoolTitleBox td .schoolTitleBoxText {
                display: inline-block;
                vertical-align: middle
            }
        </style>
    </head>

    <body>
        <table width="2155" class="table-body"
            style="margin-left: auto; margin-right:auto; background-color: white; opacity:0.6;">
            <tbody>
                <tr>
                    <td>
                        <table width="1525" align="center" style="padding-top: 1em; margin-bottom: 0em;"
                            class="schoolTitleBox">
                            <tr>
                                <td>
                                    <img width="400" src="{{url('uploads/'.$schoolInfo->stamp_img_url)}}" alt=""
                                        srcset="">
                                    <div class="schoolTitleBoxText">
                                        <h4 class="fs-5 my-2 text-center">{{$schoolInfo->name}}</h4>
                                        <h5 class="fs-4 my-2 text-center">{{$student->class_stage->name}} End of
                                            {{$current_term->name}} Report
                                        </h5>
                                    </div>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="2200" style="margin-bottom: 2em; margin-top: 1em;">
                            <tr>
                                <td style="vertical-align: top" width="1750">
                                    <table width="1700">
                                        <tr>
                                            <table width="1500" class="border-line text-center" style="font-size:2em">

                                                <tr>
                                                    <td width="300" rowspan="3" align="right"
                                                        style="border:none; padding: 0em; margin: 0em">
                                                        @if($student->user->profile_pics != "")
                                                        <img width="420"
                                                            style="border-radius: none; border: solid {{$colorsArray['mainTextColor']}} thick; margin: 0; margin-left: 10px"
                                                            src="{{url('uploads/'.$student->user->profile_pics)}}"
                                                            alt="" srcset="">
                                                        @endif
                                                    </td>
                                                    <th height="40" colspan="9">Name: <span
                                                            class="text-underline text-uppercase py-3">{{$student->user->fullname}}</span>
                                                    </th>

                                                </tr>
                                                <tr class="py-3">
                                                    <td height="40">Admission No</td>
                                                    <td>Session</td>
                                                    <td>Class</td>
                                                    <td>Sex</td>
                                                    <td>Mark Obtainable</td>
                                                    <td>Mark Obtained</td>
                                                    <td>Average Score</td>
                                                    <td>Percentage</td>
                                                    <td>Attendance</td>
                                                </tr>
                                                <tr class="py-3">
                                                    <td height="40">{{ucfirst($student->user->username)}}</td>
                                                    <td>{{$current_session->name}}</td>
                                                    <td>{{$student->class->shortname}}</td>
                                                    <td>{{ucfirst($student->user->gender)}}</td>
                                                    <td>{{$academicAssessmentsArray['markObtainable']}}</td>
                                                    <td>{{$academicAssessmentsArray['markObtained']}}</td>
                                                    <td>{{$classAssessment->average_score}}</td>
                                                    <td>{{$academicAssessmentsArray['percentage']}}</td>
                                                    <td>{{$studentAttendance}} out of {{$overallAttendance}}</td>
                                                </tr>
                                            </table>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            <td class="text-bold"
                                                style="font-size: 1.5em;font-weight: 700; color: {{$colorsArray['mainTextColor']}}">
                                                &nbsp; </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <table width="1700" class="border-line">
                                                    <thead>
                                                        <tr class="text-uppercase px-1">
                                                            <th rowspan="2"></th>
                                                            <th colspan="6">Continous Assessment</th>
                                                            <th colspan="2" rowspan="2">Term's Exam</th>
                                                            <th colspan="2" rowspan="2">Total </th>
                                                            <th colspan="8" rowspan="2">Summary of Term's Work </th>
                                                        </tr>
                                                        <tr class="text-uppercase px-1">

                                                            <th colspan="2">1st Test</th>
                                                            <th colspan="2">2nd Test</th>
                                                            <th colspan="2">3rd Test</th>
                                                        </tr>
                                                        <tr class="text-uppercase px-1">
                                                            <th>Subjects</th>
                                                            @if(active_term()->id == 2)
                                                            <th>1st Term</th>
                                                            @endif
                                                            @if(active_term()->id == 3)
                                                            <th>1st Term</th>
                                                            <th>2nd Term</th>
                                                            @endif
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
                                                        <tr class="text-center px-1" style="font-size: 1.5em;">
                                                            <td width="200" height="30" style=" padding-left: 1.1em"
                                                                class=" text-left py-0 px-2">{{$result->subject->name}}
                                                            </td>
                                                            @if(active_term()->id == 2)
                                                                @if($student->prevSubjectResult($result->subject->id, $student->id, 1)->count() == 0)
                                                                    <td></td>
                                                                @else
                                                                    <td>{{$student->prevSubjectResult($result->subject->id, $student->id, 1)->first()->total_score}}</td>
                                                                @endif
                                                            @endif
                                                            @if(active_term()->id == 3)
                                                                @if($student->prevSubjectResult($result->subject->id, $student->id, 1)->count() == 0)
                                                                    <td></td>
                                                                @else
                                                                    <td>{{$student->prevSubjectResult($result->subject->id, $student->id, 1)->first()->total_score}}</td>
                                                                @endif
                                                                @if($student->prevSubjectResult($result->subject->id, $student->id, 2)->count() == 0)
                                                                    <td></td>
                                                                @else
                                                                    <td>{{$student->prevSubjectResult($result->subject->id, $student->id, 2)->first()->total_score}}</td>
                                                                @endif
                                                            @endif
                                                            <td>10</td>
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
                                    <table width="450" align="left" style="font-size:  1.1em;">
                                        <tr>
                                            <td class="text-center text-uppercase"
                                                style="color: #000 padding: 5px; border-bottom-left-radius: 0.4em; border-bottom-right-radius: 0.4em; height: 100px; border: solid {{$colorsArray['mainTextColor']}} thin">
                                                Behaviour Assessment
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            {{-- <td class="text-bold"
                                                style="font-weight: 700; color: {{$colorsArray['mainTextColor']}}">
                                                &nbsp; </td> --}}
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="450" class="border-line border-decorated py-3">
                                                    <tr class="text-center py-3"
                                                        bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="200" class="text-left text-uppercase px-2">Behaviour
                                                        </th>
                                                        <th width="40">5</th>
                                                        <th width="40">4</th>
                                                        <th width="40">3</th>
                                                        <th width="40">2</th>
                                                        <th width="40">1</th>
                                                    </tr>
                                                    @foreach ($behaviourAssessmentsArray as $title => $mark)
                                                    <tr class="py-2">
                                                        <th width="250" style="color: #000; padding-left: 1.1em"
                                                            class="px-2 text-left text-uppercase">{{camelCase($title)}}
                                                        </th>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                        @if($mark == $i)
                                                        <td width="40" style="padding: 10px, 0">
                                                            &nbsp;
                                                            <img width="20"
                                                                src="{{URL::asset('assets/libs/svg/check.png')}}" />
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
                                    <table width="450" align="left" style="margin-top: 1em; font-size:  1.1em;">
                                        <tr>
                                            <td class="text-center text-uppercase"
                                                style="color: #000; padding: 5px; border-bottom-left-radius: 0.4em; border-bottom-right-radius: 0.4em; height: 80px; border: solid {{$colorsArray['mainTextColor']}} thin">
                                                Skill Assessment
                                            </td>
                                        </tr>
                                        <tr class="text-center text-uppercase">
                                            {{-- <td class="text-bold"
                                                style="font-weight: 700; color: {{$colorsArray['mainTextColor']}}">
                                                &nbsp; </td> --}}
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="450" class="border-line border-decorated py-2">
                                                    <tr class="text-center py-3"
                                                        bgcolor="{{$colorsArray['mainTextColor']}}" style="color:white">
                                                        <th width="250" class="text-left text-uppercase px-2 py-2">
                                                            Skills</th>
                                                        <th width="40">5</th>
                                                        <th width="40">4</th>
                                                        <th width="40">3</th>
                                                        <th width="40">2</th>
                                                        <th width="40">1</th>
                                                    </tr>
                                                    @foreach ($skillAssessmentsArray as $title => $mark)
                                                    <tr class="py-2">
                                                        <th width="250" style="color: #000; padding-left: 1.1em"
                                                            class="text-left text-uppercase">{{camelCase($title)}}</th>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                        @if($mark == $i)
                                                        <td width="40">
                                                            &nbsp;
                                                            <img width="20"
                                                                src="{{URL::asset('assets/libs/svg/check.png')}}" />
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
                                    <table width="450" class="my-3 text-left"
                                        style="font-size: 2em; border: solid {{$colorsArray['mainTextColor']}} thin; margin-top: 1em;">
                                        <tr class="px-3">
                                            <th height="40" class="text-left">Class Teacher's Remark:</th>
                                        </tr>
                                        <tr class="px-3">
                                            <td height="40">{{$classTeacherComment}}</td>
                                        </tr>
                                    </table>
                                    <table width="450" class="my-3 text-left"
                                        style="font-size: 2em; border: solid {{$colorsArray['mainTextColor']}} thin; margin-top: 1em">
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