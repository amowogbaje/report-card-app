<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Result;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;
use App\Models\ClassLevel;
use Illuminate\Support\Facades\Log;


class ProcessSubjectResult extends Component
{
    public $subject_id, $class_id;
    

    // public function mount() {

    // }


    public function process() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        
        $resultObject = Result::where('subject_id', $this->subject_id)
                                ->where('class_code', $class_code)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id);
        $highestScoreInSubject = $resultObject->max('cumulative_percentage');
        $updateWithHighestScore = $resultObject->update(['highest_score' => $highestScoreInSubject]);
        $lowestScoreInSubject = $resultObject->where('cumulative_percentage', '>', 0)->min('cumulative_percentage');
        $updateWithLowestScore = $resultObject->update(['lowest_score' => $lowestScoreInSubject]);
        $averageScoreInSubject = $resultObject->avg('cumulative_percentage');
        $updateWithAverageScore = $resultObject->update(['average_score' => round($averageScoreInSubject)]);
        $updateResultStatusInTeacherSubjectClass = TeacherSubjectClass::where('subject_id', $this->subject_id)
                                                                        ->where('class_id', $this->class_id)
                                                                        ->where('session_id', $current_session_id)
                                                                        ->where('term_id', $current_term_id)
                                                                        ->update(['class_result_processed'=> 1]);

        // $this->emit('swal:notify', [
        //    'title' => 'Subject Processed',
            // 'text' => "....",
        //]);

        //$this->render();
    }

    public function computeSubjectPercentage() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $subjectResults = Result::where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->where('subject_id', $this->subject_id)
                            ->get();
        if($current_term_id == 1) {
            foreach($subjectResults as $result) {
                $studentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->update(
                                                [
                                                    'cumulative_percentage' => $result->total_score,
                                                    'percentage_computed' => 1
                                                ]
                                            );
            }
        }

        if($current_term_id == 2) {
            foreach($subjectResults as $result) {
                $checkFirstTermSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->where('total_score', ">", 0)
                                            ->count();
                if($checkFirstTermSubjectResult != 0) {
                    $studentPreviousSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                }
                
                $studentCurrentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 2)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                if($checkFirstTermSubjectResult != 0) {
                    $cumulativePercentage = ((int) $studentPreviousSubjectResult + (int) $studentCurrentSubjectResult)/2;
                }
                else {
                    $cumulativePercentage = $studentCurrentSubjectResult;
                }
                $studentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->update(
                                                [
                                                    'cumulative_percentage' => round($cumulativePercentage),
                                                    'percentage_computed' => 1
                                                ]
                                            );
            }
        }

        if($current_term_id == 3) {
            foreach($subjectResults as $result) {
                $checkFirstTermSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->where('total_score', ">", 0)
                                            ->count();
                if($checkFirstTermSubjectResult != 0) {
                    $studentPreviousSubjectResult1 = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                }

                $checkSecondTermSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 2)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->where('total_score', ">", 0)
                                            ->count();
                if($checkSecondTermSubjectResult != 0) {
                    $studentPreviousSubjectResult2 = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 2)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                }
                
                
                $studentCurrentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 3)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                                            
                $sumScores = 0;
                $noOftermPresent = 0;
                
                if($checkFirstTermSubjectResult != 0) {
                    $sumScores = (int) $studentPreviousSubjectResult1;
                    $noOftermPresent++;
                }
                
                if($checkSecondTermSubjectResult != 0) {
                    $sumScores = $sumScores + (int) $studentPreviousSubjectResult2;
                    $noOftermPresent++;
                    
                }
                if((int) $studentCurrentSubjectResult != 0) {
                    $sumScores = $sumScores + (int) $studentCurrentSubjectResult;
                    $noOftermPresent++;
                }
                elseif((int) $studentCurrentSubjectResult == 0) {
                    if($noOftermPresent == 0) {
                        $noOftermPresent = 1;
                    }
                }
                $cumulativePercentage = $sumScores/$noOftermPresent;
                
                $studentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->update(
                                                [
                                                    'cumulative_percentage' => round($cumulativePercentage),
                                                    'percentage_computed' => 1
                                                ]
                                            );
            }
        }

        // $this->emit('swal:notify', [
        //    'title' => 'Percentage Computed',
        //    'text' => "....",
        // ]);

        // $this->render();

    }
    
    public function processAtOnce() {
        $this->computeSubjectPercentage();
        $this->process();
        $this->gradeSubjectScores();
        $this->distributeSubjectPosition();
        // sleep(7);
        return redirect(request()->header('Referer'));
        
    }

    public function calcPosition(array $scores, $studentScore) {
        $position = "NA";
        rsort($scores);
        $scorePosition = [];
        
        // dd(($scores));
        foreach ($scores as $pos => $score) {
            $pos = $pos + 1;
            $pos = "$pos";
            if(strlen($pos) == 1) {
                if(substr($pos, strlen($pos)-1)  == 1 ) { $position = $pos ."<sup>st</sup>"; }
                elseif(substr($pos, strlen($pos)-1) == 2) { $position = $pos ."<sup>nd</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 3) { $position = $pos ."<sup>rd</sup>";}
                else {$position = $pos."<sup>th<sup>";}
            }
            else if(strlen($pos) >= 2) {
                if(substr($pos, strlen($pos)-1)  == 1 && substr($pos,0,1) !=1) { $position = $pos ."<sup>st</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 2 && substr($pos,0,1) !=1) { $position = $pos ."<sup>nd</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 3 && substr($pos,0,1) !=1) { $position = $pos ."<sup>rd</sup>";}
                else {$position = $pos."<sup>th<sup>";}
            }

            $scorePosition["$position"] = $score;
        }

        

        $noDuplicates = array_unique($scorePosition);
        // return json_encode($noDuplicates);
        return array_search($studentScore, $noDuplicates);

    }
    

    public function distributeSubjectPosition() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        $results = Result::where('subject_id', $this->subject_id)
                                ->where('class_code', $class_code)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->get();
            
        $allScores = Result::where('subject_id', $this->subject_id)
                            ->where('class_code', $class_code)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->pluck('cumulative_percentage')->toArray();
        foreach ($results as $result) {
            Result::where('subject_id', $this->subject_id)
                    ->where('class_code', $class_code)
                    ->where('session_id', $current_session_id)
                    ->where('term_id', $current_term_id)
                    ->where('student_id', $result->student_id)
                    ->update(["position"=>$this->calcPosition($allScores, $result->cumulative_percentage)]);
        }

        
    }

    public function getGradeForSenior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F9";}
        if($scores >= 40 && $scores <= 44) {$grade = "E8";}
        if($scores >= 45 && $scores <= 49) {$grade = "D7";}
        if($scores >= 50 && $scores <= 54) {$grade = "C6";}
        if($scores >= 55 && $scores <= 59) {$grade = "C5";}
        if($scores >= 60 && $scores <= 64) {$grade = "C4";}
        if($scores >= 65 && $scores <= 69) {$grade = "B3";}
        if($scores >= 70 && $scores <= 74) {$grade = "B2";}
        if($scores >= 75 && $scores <= 100) {$grade = "A1";}

        return $grade;
    }

    public function getGradeForJunior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F";}
        if($scores >= 40 && $scores <= 49) {$grade = "P";}
        // if($scores >= 45 && $scores <= 49) {$grade = "D";}
        if($scores >= 50 && $scores <= 59) {$grade = "C";}
        if($scores >= 60 && $scores <= 69) {$grade = "B";}
        if($scores >= 70 && $scores <= 100) {$grade = "A";}

        return $grade;
    }
    public function gradeSubjectScores() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        
        $classLevel = ClassLevel::find($this->class_id);
        if (!$classLevel) {
            Log::error('Class not found for class_id: ' . $this->class_id);
            return;
        }
    
        $class_code = $classLevel->code;
        $results = Result::where('subject_id', $this->subject_id)
                            ->where('class_code', $class_code)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->get();
    
        Log::info('Number of results to grade: ' . $results->count());
    
        foreach ($results as $student) {
            $grade = null;
            if ($student->classlevel->class_stage_id < 7) {
                $grade = $this->getGradeForJunior($student->cumulative_percentage);
            } elseif ($student->classlevel->class_stage_id == 7) {
                $grade = $this->getGradeForSenior($student->cumulative_percentage);
            }
    
            if ($grade !== null) {
                $student->update(["grade" => $grade]);
            }
        }
    
        // Uncomment this if using Livewire or similar for frontend notifications
        // $this->emit('swal:notify', [
        //     'title' => 'Grading Completed',
        //     'text' => "....",
        // ]);
    }


    


    public function render()
    {
        $class_code = ClassLevel::where('id', $this->class_id)->first()->code;
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $isResultUploaded = TeacherSubjectClass::where('subject_id', $this->subject_id)
                                                ->where('class_id', $this->class_id)
                                                ->where('term_id', $current_term_id)
                                                ->where('session_id', $current_session_id)
                                                ->first()->result_uploaded;
        $isResultProcessed = TeacherSubjectClass::where('subject_id', $this->subject_id)
                                                ->where('class_id', $this->class_id)
                                                ->where('term_id', $current_term_id)
                                                ->where('session_id', $current_session_id)
                                                ->first()->class_result_processed;
        $resultObject = Result::where('subject_id', $this->subject_id)
                                ->where('class_code', $class_code)
                                ->where('term_id', $current_term_id)
                                ->where('session_id', $current_session_id);
        $zeroExistInLowestScore = Result::where('subject_id', $this->subject_id)
                                ->where('class_code', $class_code)
                                ->where('term_id', $current_term_id)
                                ->where('session_id', $current_session_id)
                                ->where('cumulative_percentage', 0)
                                ->count();
        if($resultObject->count() == 0) {
            $isPercentageCalculated = 0;
            $averageScore = 0;
            $highestScore = 0;
            $lowestScore = 0;
        }
        else {
            $isPercentageCalculated = $resultObject->first()->percentage_computed;
            $averageScore = $resultObject->first()->average_score;
            $lowestScore = $resultObject->first()->lowest_score;
            $highestScore = $resultObject->first()->highest_score;
        }
        return view('livewire.teacher.process-subject-result', compact('isResultProcessed', 'isPercentageCalculated', 'averageScore', 'highestScore', 'lowestScore', 'isResultUploaded', 'zeroExistInLowestScore'));
    }
}
