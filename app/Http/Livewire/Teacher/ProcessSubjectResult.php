<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Result;
use App\Models\Subject;
use App\Models\TeacherSubjectClass;


class ProcessSubjectResult extends Component
{
    public $subject_id, $class_id;
    

    // public function mount() {

    // }


    public function process() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $resultObject = Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id);
        $highestScoreInSubject = $resultObject->max('cumulative_percentage');
        $updateWithHighestScore = $resultObject->update(['highest_score' => $highestScoreInSubject]);
        $lowestScoreInSubject = $resultObject->min('cumulative_percentage');
        $updateWithLowestScore = $resultObject->update(['lowest_score' => $lowestScoreInSubject]);
        $averageScoreInSubject = $resultObject->avg('cumulative_percentage');
        $updateWithAverageScore = $resultObject->update(['average_score' => round($averageScoreInSubject)]);
        $updateResultStatusInTeacherSubjectClass = TeacherSubjectClass::where('subject_id', $this->subject_id)
                                                                        ->where('class_id', $this->class_id)
                                                                        ->where('session_id', $current_session_id)
                                                                        ->where('term_id', $current_term_id)
                                                                        ->update(['class_result_processed'=> 1]);

        $this->emit('swal:notify', [
            'title' => 'Subject Processed',
            // 'text' => "....",
        ]);

        $this->render();
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
                $studentPreviousSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                $studentCurrentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 2)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $subject_id)
                                            ->first()->total_score;
                $cumulativePercentage = ($studentPreviousSubjectResult + $studentCurrentSubjectResult)/2;
                $studentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $subject_id)
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
                $studentPreviousSubjectResult1 = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 1)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $this->subject_id)
                                            ->first()->total_score;
                $studentPreviousSubjectResult2 = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 2)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $subject_id)
                                            ->first()->total_score;
                $studentCurrentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', 3)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $subject_id)
                                            ->first()->total_score;
                $cumulativePercentage = ($studentPreviousSubjectResult1 + $studentPreviousSubjectResult2 + $studentCurrentSubjectResult)/3;
                $studentSubjectResult = Result::where('session_id', $current_session_id)
                                            ->where('term_id', $current_term_id)
                                            ->where('student_id', $result->student_id)
                                            ->where('subject_id', $subject_id)
                                            ->update(
                                                [
                                                    'cumulative_percentage' => round($cumulativePercentage),
                                                    'percentage_computed' => 1
                                                ]
                                            );
            }
        }

        $this->emit('swal:notify', [
            'title' => 'Percentage Computed',
            'text' => "....",
        ]);

        $this->render();

    }

    public function calcPostion(array $scores, $score) {
        $position = "1st";
        sort($scores);
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
            else if(strlen($pos) == 2) {
                if(substr($pos, strlen($pos)-1)  == 1 && substr($pos,0,1) !=1) { $position = $pos ."<sup>st</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 2 && substr($pos,0,1) !=1) { $position = $pos ."<sup>nd</sup>";}
                elseif(substr($pos, strlen($pos)-1) == 3 && substr($pos,0,1) !=1) { $position = $pos ."<sup>rd</sup>";}
                else {$position = $pos."<sup>th<sup>";}
            }

            $scorePosition["$position"] = $score;
        }

        $noDuplicates = array_unique($scorePosition);
        return array_search($score, $noDuplicates);

    }
    

    public function distributeSubjectPosition() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $result = Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->get();
        if($current_term_id <=2) {
            foreach ($result as $student) {
                $allScores = Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->pluck('total_score')->toArray();
                Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $student->student_id)
                                ->update(["position"=>$this->calcPostion($allScores, $student->total_score)]);
            }
        }
        elseif($current_term_id ==3) {
            foreach ($result as $student) {
                $allScores = Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->pluck('cumulative_percentage')->toArray();
                Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->where('student_id', $student->student_id)
                                ->update(["position"=>$this->calcPostion($allScores, $student->cumulative_percentage)]);
                    
            }
        }
        $this->emit('swal:notify', [
            'title' => 'Position Distributed',
            'text' => "....",
        ]);
    }

    public function getGradeForSenior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F9";}
        if($scores >= 40 && $scores <= 44) {$grade = "E8";}
        if($scores >= 45 && $scores <= 49) {$grade = "D7";}
        if($scores >= 50 && $scores <= 54) {$grade = "C6";}
        if($scores >= 55 && $scores <= 59) {$grade = "C5";}
        if($scores >= 60 && $scores <= 65) {$grade = "C4";}
        if($scores >= 66 && $scores <= 69) {$grade = "B3";}
        if($scores >= 70 && $scores <= 74) {$grade = "B2";}
        if($scores >= 75 && $scores <= 100) {$grade = "A1";}

        return $grade;
    }

    public function getGradeForJunior($scores) {
        $grade = "";
        if($scores < 40) {$grade = "F";}
        if($scores >= 40 && $scores <= 44) {$grade = "E";}
        if($scores >= 45 && $scores <= 49) {$grade = "D";}
        if($scores >= 50 && $scores <= 59) {$grade = "C";}
        if($scores >= 60 && $scores <= 69) {$grade = "B";}
        if($scores >= 70 && $scores <= 100) {$grade = "A";}

        return $grade;
    }
    public function gradeSubjectScores() {
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $result = Result::where('subject_id', $this->subject_id)
                                ->where('class_id', $this->class_id)
                                ->where('session_id', $current_session_id)
                                ->where('term_id', $current_term_id)
                                ->get();
        if($current_term_id <=2) {
            foreach ($result as $student) {
                if($student->classlevel->class_stage_id < 7) {
                    Result::where('subject_id', $this->subject_id)
                            ->where('class_id', $this->class_id)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->where('student_id', $student->student_id)
                            ->update(["grade"=>$this->getGradeForJunior($student->total_score)]);
                }
                elseif($student->classlevel->class_stage_id == 7) {
                    Result::where('subject_id', $this->subject_id)
                            ->where('class_id', $this->class_id)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->where('student_id', $student->student_id)
                            ->update(["grade"=>$this->getGradeForSenior($student->total_score)]);
                }
                
            }
        }
        elseif($current_term_id ==3) {
            foreach ($result as $student) {
                if($student->classlevel->class_stage_id < 7) {
                    Result::where('subject_id', $this->subject_id)
                            ->where('class_id', $this->class_id)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->where('student_id', $student->student_id)
                            ->update(["grade"=>$this->getGradeForJunior($student->total_score)]);
                }
                elseif($student->classlevel->class_stage_id == 7) {
                    Result::where('subject_id', $this->subject_id)
                            ->where('class_id', $this->class_id)
                            ->where('session_id', $current_session_id)
                            ->where('term_id', $current_term_id)
                            ->where('student_id', $student->student_id)
                            ->update(["grade"=>$this->getGradeForSenior($student->total_score)]);
                }
                    
            }
        }
        $this->emit('swal:notify', [
            'title' => 'Grading Completed',
            'text' => "....",
        ]);
    }

    


    public function render()
    {
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
                                ->where('class_id', $this->class_id)
                                ->where('term_id', $current_term_id)
                                ->where('session_id', $current_session_id);
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
        return view('livewire.teacher.process-subject-result', compact('isResultProcessed', 'isPercentageCalculated', 'averageScore', 'highestScore', 'lowestScore', 'isResultUploaded'));
    }
}
