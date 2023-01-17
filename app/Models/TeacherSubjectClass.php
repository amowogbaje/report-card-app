<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubjectClass extends Model
{
    use HasFactory;

    public function class() {
        return $this->belongsTo(ClassLevel::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
