<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    use HasFactory;
    
    public function sessionYear() {
        return $this->belongsTo(SessionYear::class, 'session_id');
    }
    
    public function termYear() {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
