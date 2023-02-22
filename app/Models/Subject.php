<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Result;
use App\Models\ClassLevel;

class Subject extends Model
{
    use HasFactory;

    public  function class_stage() {
        return $this->belongsTo(ClassStage::class);
    }

    public function classlevels($classStageId) {
        return ClassLevel::where('class_stage_id', $classStageId)->get();

        // subject ()
    }

    public function noOfClass($classStageId) {
        return ClassLevel::where('class_stage_id', $classStageId)->count(); 
    }

    public function studentRegistered($studentId, $subjectId) {
        return Result::where('student_id', $studentId)
                ->where('term_id', active_term()->id)
                ->where('session_id', active_session()->id)
                ->where('subject_id', $subjectId)
                ->count();
    }
}
