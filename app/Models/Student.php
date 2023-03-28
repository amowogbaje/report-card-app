<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Teacher;

class Student extends Model
{
    use HasFactory;

    public  function class() {
        return $this->belongsTo(ClassLevel::class);
    }

    public function subject($id) {
        return Subject::where('id', $id)->first();
    }

    public  function user() {
        return $this->belongsTo(User::class);
    }

    public function payment_codes() {
        return $this->hasOne(PaymentCode::class);
    }

    public function classteacher($class_id) {
        $teacherObject = ClassTeacher::join('teachers', 'teachers.id', '=', 'class_teachers.teacher_id')
                    ->join('users', 'users.id', '=', 'teachers.user_id')
                    ->where('class_teachers.class_id', $class_id);
        return $teacherObject;
    }

    

    public function subjectResult($subject_id, $student_id) {
        return Result::where('subject_id', $subject_id)
                    ->where('student_id', $student_id);
    }
    public function prevSubjectResult($subject_id, $student_id, $termId) {
        return Result::where('subject_id', $subject_id)
                    ->where('student_id', $student_id)
                    ->where('term_id', $termId)
                    ->where('session_id', active_session()->id);
    }

    public function result() {
        return $this->hasMany(Result::class);
    }

    public function class_stage() {
        return $this->belongsTo(ClassStage::class); 
    }

    
}
