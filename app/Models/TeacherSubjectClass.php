<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TeacherSubjectClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'term_id',
        'teacher_id',
        'subject_id',
        'class_id',
        'class_code',
        'periods'
        ];

    public function class() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
    public function resultCount($subjectId, $classId) {
        return Result::where('subject_id', $subjectId)
                    ->where('class_id', $classId)
                    ->count();
    }

    public function user($userId) {
        return User::where('id', $userId)->first();
    }
}
