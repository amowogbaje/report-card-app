<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Teacher;
use App\Models\User;
use App\Models\ClassTeacher;

class ClassLevel extends Model
{
    use HasFactory;

    // public $attributes['firstname'] = ['firstname'];

    

    public function teacher($class_id) {
        $teacherObject = ClassTeacher::join('teachers', 'teachers.id', '=', 'class_teachers.teacher_id')
                    ->join('users', 'users.id', '=', 'teachers.user_id')
                    ->where('class_teachers.class_id', $class_id)
                    ->where('session_id', active_session()->id)
                    ->where('term_id', active_term()->id);
        return $teacherObject;
    }

    public function class($class_id) {
        return ClassTeacher::where('class_id' ,$class_id)->first();
    }

    public  function class_stage() {
        return $this->belongsTo(ClassStage::class);
    }

    

    

}
