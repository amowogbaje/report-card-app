<?php

namespace App\Models;

use App\Models\TeacherSubjectClass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    
    protected $fillable = ['grade'];

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
                                            ->where('teacher_subject_classes.session_id', active_session()->id)
                                            ->where('teacher_subject_classes.term_id', active_term()->id)
                                            ->first();                                           
        return $subjectTeacher;
    }
    public function previousSubjectTeacher($subject_id, $class_id, $session_id, $term_id) {
        $subjectTeacher = TeacherSubjectClass::join('teachers', 'teachers.id', '=', 'teacher_subject_classes.teacher_id')
                                            ->join('users', 'users.id', '=', 'teachers.user_id')
                                            ->where('teacher_subject_classes.subject_id', $subject_id)                                            
                                            ->where('teacher_subject_classes.class_id', $class_id)
                                            ->where('teacher_subject_classes.session_id', $session_id)
                                            ->where('teacher_subject_classes.term_id', $term_id)
                                            ->first();                                           
        return $subjectTeacher;
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
    
    public function classSubject($student, $subject_id) {
        $result = Result::where('session_id', active_session()->id)
                ->where('term_id', active_term()->id)
                ->where('class_code', $student->class_code)
                ->where('subject_id', $subject_id);
        return $result;
    }
    public function previousClassSubject($student, $subject_id, $session_id, $term_id) {
        $result = Result::where('session_id', $session_id)
                ->where('term_id', $term_id)
                ->where('class_code', $student->class_code)
                ->where('subject_id', $subject_id);
        return $result;
    }

    public function firstterm($student, $subject_id) {

        $result = Result::where('session_id', active_session()->id)
                ->where('term_id', 1)
                ->where('student_id', $student->id)
                ->where('class_id', $student->class_id)
                ->where('subject_id', $subject_id)
                ->first();
                // ->where('grade', '!=', null);

        return $result;
    }

    public function secondterm($student, $subject_id) {

        $result = Result::where('session_id', active_session()->id)
                ->where('term_id', 2)
                ->where('student_id', $student->id)
                ->where('class_id', $student->class_id)
                ->where('subject_id', $subject_id)
                ->first();
                // ->where('grade', '!=', null);

        return $result;
    }

    

}
