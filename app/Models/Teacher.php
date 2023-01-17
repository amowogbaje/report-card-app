<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public  function class() {
        return $this->belongsTo(ClassLevel::class);
    }

    public  function user() {
        return $this->belongsTo(User::class);
    }
}
