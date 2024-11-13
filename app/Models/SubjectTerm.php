<?php

namespace App\Models;

use App\Models\TeacherSubjectClass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTerm extends Model
{
    use HasFactory;

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function classlevel() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }
    
    public function session_year() {
        return $this->belongsTo(SessionYear::class);
    }
    public function class_stage() {
        return $this->belongsTo(ClassStage::class);
    }
    public function term() {
        return $this->belongsTo(Term::class);
    }
    

}
