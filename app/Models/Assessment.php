<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ClassTeacher;
use App\Models\Student;

class Assessment extends Model
{
    use HasFactory;
    public function classlevel() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }
    public function student() {
        return $this->belongsTo(Student::class);
    }
    
    public function getStudentName($student_id) {
        return Student::where('id', $student_id)->first();
    }
    
    public function teacher($class_id) {
        $teacherObject = ClassTeacher::join('teachers', 'teachers.id', '=', 'class_teachers.teacher_id')
                    ->join('users', 'users.id', '=', 'teachers.user_id')
                    ->where('class_teachers.class_id', $class_id)
                    ->where('session_id', active_session()->id)
                    ->where('term_id', active_term()->id);
        return $teacherObject;
    }
    
}
