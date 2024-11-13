<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Teacher;
use App\Models\Assessment;
use App\Models\Result;

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
        // return $this->hasOne(PaymentCode::class);
        return $this->hasOne(PaymentCode::class, 'student_id')->where('payment_codes.session_id', '=', active_session()->id)->where('payment_codes.term_id', '=', active_term()->id);
    }
    
    public function hasResultforCurrentTerm($student_id) {
        return Result::where(student_id, $student_id)->where('session_id', '=', active_session()->id)->where('term_id', '=', active_term()->id)->count();
    }

    public function classteacher($class_id) {
        $teacherObject = ClassTeacher::join('teachers', 'teachers.id', '=', 'class_teachers.teacher_id')
                    ->join('users', 'users.id', '=', 'teachers.user_id')
                    ->where('class_teachers.class_id', $class_id)
                    ->where('class_teachers.term_id', active_term()->id)
                    ->where('class_teachers.session_id', active_session()->id);
        return $teacherObject;
    }
    
    public function classstudent($student_id) {
        $teacherObject = ClassStudent::join('students', 'student.id', '=', 'class_students.student_id')
                    ->join('users', 'users.id', '=', 'students.user_id')
                    ->where('class_students.class_id', $student_id)
                    ->where('class_students.term_id', active_term()->id)
                    ->where('class_students.session_id', active_session()->id);
        return $teacherObject;
    }
    
    public function assessment($student_id) {
        return Assessment::where('session_id', active_session()->id)
                            ->where('term_id', active_term()->id)
                            ->where('student_id', $student_id)
                            ->first();
    }
    
    public function previousassessment($session_id, $term_id, $student_id) {
        return Assessment::where('session_id', $session_id)
                            ->where('term_id', $term_id)
                            ->where('student_id', $student_id)
                            ->first();
    }

    

    public function subjectResult($subject_id, $student_id) {
        return Result::where('subject_id', $subject_id)
                    ->where('student_id', $student_id)
                    ->where('term_id', active_term()->id)
                    ->where('session_id', active_session()->id);
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
