<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TeacherSubjectClass extends Model
{
    use HasFactory;

    public function class() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function user($userId) {
        return User::where('id', $userId)->first();
    }
}
