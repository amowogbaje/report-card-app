<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SessionYear;
use App\Models\User;
use App\Models\Teacher;
use App\Models\TeacherSubjectClass;

use Auth;

class IsSubjectTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $class_id = $request->route('class_id');
        $subject_id = $request->route('subject_id');
        if( Auth::user()->role == 'admin') {
            return $next($request);
        }
        
        elseif( Auth::user()->role == 'teacher') {
            $teacher_id = Teacher::where('user_id', Auth::user()->id)->first()->id;
            $teacherSubjectClass = TeacherSubjectClass::where('class_id', $class_id)->where('term_id', active_term()->id)
                            ->where('session_id', active_session()->id)
                             ->where('subject_id', $subject_id)
                             ->where('teacher_id', $teacher_id)
                             ->count();
            if($teacherSubjectClass != 0) {
                return $next($request);
            }
        }
        
        else{
            return redirect('/403');
        }
        
    }
}
