<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClassLevel;
use App\Models\Student;
use App\Models\Result;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;
use App\Models\SchoolInfo;
use App\Models\Assessment;
use App\Models\ClassAssessment;
use DB;
use PDF;
use Auth;

class ResultController extends Controller
{
    //
    public function teacherspreadsheetforAdmin($class_id, $subject_id) {
        $students = Student::where('class_id', $class_id)->where('status', 1)->get();
        return view('admin.admin-teacher-spreadsheet', compact('students', 'subject_id'));
    }

    public function teacherspreadsheet($class_id, $subject_id) {
        $subject = Subject::where('id', $subject_id)->first();
        if($subject->category == NULL || $subject->category == "") {
            $students = Student::where('class_id', $class_id)->where('status', 1)->get();
        }
        else {
            $students = Student::where('class_id', $class_id)->where('status', 1)->where('category', $subject->category)->get();
        }
        
        // return $subject;
        return view('teacher-spreadsheet', compact('students', 'subject_id', 'class_id', 'subject'));
    }

    public function submitScores(Request $request) {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $scores = $request->get('scores');
        $first_term_scores = $request->get('first_term_scores');
        $second_term_scores = $request->get('second_term_scores');

        if(isset($first_term_scores))
        {
            // return $first_term_scores;
            foreach($first_term_scores as $key => $firstTermTotalScore){
                if(($firstTermTotalScore) != "") {
                    $resultExist = Result::where('subject_id', $request->subject_id)
                                    ->where('class_id', $request->class_id)
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', 1)
                                    ->where('student_id', $key)
                                    ->count();
                    if($resultExist == 0) {
                        DB::table('results')->insert([
                            'session_id' => $current_session_id,
                            'term_id' => 1,
                            'subject_id' => $request->subject_id,
                            'class_id' => $request->class_id,
                            'student_id' => $key,
                            'total_score' => $firstTermTotalScore,
                        ]);
                    }
                    else {
                        DB::table('results')
                            ->where('session_id', $current_session_id)
                            ->where('term_id', 1)
                            ->where('subject_id', $request->subject_id)
                            ->where('class_id', $request->class_id)
                            ->where('student_id', $key)
                            ->update([ 'total_score' => $firstTermTotalScore]);
                    }
                }
                    
            }
        }

        if(isset($second_term_scores))
        {
            foreach($second_term_scores as $key => $secondTermTotalScore){
                // return $score["'ca_1'"];
                if(trim($secondTermTotalScore) != "") {
                    $resultExist = Result::where('subject_id', $request->subject_id)
                                    ->where('class_id', $request->class_id)
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', 2)
                                    ->where('student_id', $key)
                                    ->count();
                    if($resultExist == 0) {
                        DB::table('results')->insert([
                            'session_id' => $current_session_id,
                            'term_id' => 2,
                            'subject_id' => $request->subject_id,
                            'class_id' => $request->class_id,
                            'student_id' => $key,
                            'total_score' => $secondTermTotalScore,
                        ]);
                    }
                    else {
                        DB::table('results')
                            ->where('session_id', $current_session_id)
                            ->where('term_id', 2)
                            ->where('subject_id', $request->subject_id)
                            ->where('class_id', $request->class_id)
                            ->where('student_id', $key)
                            ->update([ 'total_score' => $secondTermTotalScore]);
                    }
                }
                    
            }
        }

        foreach($scores as $key => $score){
            // return $score["'ca_1'"];
            $tca = $score["'ca_1'"] + $score["'ca_2'"] + $score["'ca_3'"];
            $totalScore = $tca + $score["'exam'"];
            $resultExist = Result::where('subject_id', $request->subject_id)
                                ->where('class_id', $request->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $key)
                                ->count();
                if($resultExist == 0) {
                    DB::table('results')->insert([
                        'session_id' => $current_session_id,
                        'term_id' => $current_term_id,
                        'subject_id' => $request->subject_id,
                        'class_id' => $request->class_id,
                        'student_id' => $key,
                        'ca_1' => $score["'ca_1'"],
                        'ca_2' => $score["'ca_2'"],
                        'ca_3' => $score["'ca_3'"],
                        'totalca' => $tca,
                        'exam' => $score["'exam'"],
                        'total_score' => $totalScore,
                    ]);
                }
                else {
                    DB::table('results')
                        ->where('session_id', $current_session_id)
                        ->where('term_id', $current_term_id)
                        ->where('subject_id', $request->subject_id)
                        ->where('class_id', $request->class_id)
                        ->where('student_id', $key)
                        ->update([
                            'ca_1' => $score["'ca_1'"],
                            'ca_2' => $score["'ca_2'"],
                            'ca_3' => $score["'ca_3'"],
                            'totalca' => $tca,
                            'exam' => $score["'exam'"],
                            'total_score' => $totalScore,
                        ]);
                }
            
        }

        $totalScoreUploaded = Result::where('subject_id', $request->subject_id)
                                    ->where('class_id', $request->class_id)
                                    ->where('session_id', $current_session_id)
                                    ->where('term_id', $current_term_id)
                                    ->sum('exam');
        if($totalScoreUploaded != 0) {
            $updateResultStatus = TeacherSubjectClass::where('subject_id', $request->subject_id)
                                                    ->where('class_id', $request->class_id)
                                                    ->where('session_id', $current_session_id)
                                                    ->where('term_id', $current_term_id)
                                                    ->update(['result_uploaded' => 1, 'class_result_processed' => 0]);
            $updateResultStatus = Result::where('subject_id', $request->subject_id)
                                                    ->where('class_id', $request->class_id)
                                                    ->where('session_id', $current_session_id)
                                                    ->where('term_id', $current_term_id)
                                                    ->update(['percentage_computed' => 0]);
        }
        
        return back()->with('success', 'Scores has been saved');
        // return "ready to go";
    }

    

    public function downloadResult($studentId) {
        
        $resultIsReady = 0;
        $skillAssessmentsArray = [];
        $behaviourAssessmentsArray = [];
        $physicalAssessmentArray = [];
        $academicAssessmentsArray = [];
        $colorsArray = [
            "primaryColor" => "",
            "secondaryColor" => "",
            "secondaryTextColor" => "brown",
            "mainTextColor" => "brown",
            "secondaryColor" => "blue",
            "mainColor" => "brown",
        ];
        
        $schoolInfo = school_info();

        $current_term = active_term();
        $current_session = active_session();
        $student = Student::where('id', $studentId)->first();
        $noInClass = Student::where('class_id', $student->class_id)->count();
        $studentAssessment = Assessment::where('session_id', $current_session->id)
                                ->where('term_id', $current_term->id)
                                ->where('student_id', $studentId)
                                ->where('school_info_id', $student->user->school_info_id)
                                ->first();
        $classAssessment = ClassAssessment::where('session_id', $current_session->id)
                                        ->where('term_id', $current_term->id)
                                        ->where('class_id', $student->class_id)
                                        ->first();
        // return $classAssessment;
        $physicalAssessment = $studentAssessment->physical_assessments;
        $behaviourAssessments = $studentAssessment->behavior_assessments;
        $skillAssessments = $studentAssessment->skill_assessments;
        $academicAssessments = $studentAssessment->academic_assessments;
        $studentAttendance = $studentAssessment->student_attendance;
        $overallAttendance = $studentAssessment->overall_attendance;
        $principalComment = $studentAssessment->principal_comment;
        $classTeacherComment = $studentAssessment->class_teacher_comment;
        if($physicalAssessment != "") {
            $physicalAssessmentArray = json_decode(html_entity_decode($physicalAssessment), true);
        }
        if($behaviourAssessments != "") {
            $behaviourAssessmentsArray = json_decode(html_entity_decode($behaviourAssessments), true);
        }
        if($skillAssessments != "") {
            $skillAssessmentsArray = json_decode(html_entity_decode($skillAssessments), true);
        }
        if($academicAssessments != "") {
            $academicAssessmentsArray = json_decode(html_entity_decode($academicAssessments), true);
        }
        

        if($physicalAssessment != "" && $behaviourAssessments != "" && $skillAssessments != "" && $academicAssessments != "") {
            if(empty($physicalAssessmentArray) && empty($behaviourAssessmentsArray) && empty($skillAssessmentsArray) && empty($academicAssessments)) {
                $resultIsReady = 1;
            }
            else{
                $resultIsReady = 0;
            }
            
        }
        elseif($physicalAssessment == NULL || $behaviourAssessments == NULL || $skillAssessments == NULL || $academicAssessments ==NULL) {
            $resultIsReady = 0;
        }
        
        $results = Result::where('session_id', $current_session->id)
                        ->where('term_id', $current_term->id)
                        ->where('student_id', $studentId)
                        ->where('class_id', $student->class_id)
                        ->get();
        
        
        // return view('student-report-card-basic', compact('student', 'results', 'resultIsReady', 'skillAssessmentsArray', 'behaviourAssessmentsArray', 'physicalAssessmentArray', 'academicAssessmentsArray', 'current_term', 'current_session', 'noInClass', 'classAssessment', 'schoolInfo', 'classTeacherComment', 'principalComment', 'colorsArray'));
        $pdf = PDF::loadView('student-report-card-basic', compact('student', 'results', 'resultIsReady', 'skillAssessmentsArray', 'behaviourAssessmentsArray', 'physicalAssessmentArray', 'academicAssessmentsArray', 'current_term', 'current_session', 'noInClass' ,'classAssessment', 'schoolInfo', 'studentAttendance', 'overallAttendance', 'classTeacherComment', 'principalComment', 'colorsArray'))
                    ->setPaper('a1', 'landscape');
        return $pdf->download($student->user->fullname. " Report Card.pdf");
    }

    
}
