<?php

namespace App\Models;

use App\Models\TeacherSubjectClass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function classlevel() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }

    public function subjectTeacher($subject_id, $class_id) {
        $subjectTeacher = TeacherSubjectClass::join('teachers', 'teachers.id', '=', 'teacher_subject_classes.teacher_id')
                                            ->join('users', 'users.id', '=', 'teachers.user_id')
                                            ->where('teacher_subject_classes.subject_id', $subject_id)                                            
                                            ->where('teacher_subject_classes.class_id', $class_id)
                                            ->first();                                           
        return $subjectTeacher;
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    

}
