<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SessionYear;
use App\Models\Subject;
use App\Models\ClassLevel;
use App\Models\SubjectTerm;
use App\Models\TeacherSubjectClass;

use Auth;

class CanDoActivities
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
        $checkActiveSession = SessionYear::where('active', 1)->count();
        $noOfSubjectsPerClass = (SubjectTerm::where('session_id', active_session()->id)->where('term_id', active_term()->id)->count());
        
        if($checkActiveSession == 0) {
            $isAnySessionActive = 0;
        }
        else {
            $isAnySessionActive = 1;
        }
        if(!$isAnySessionActive) {

            if(Route::currentRouteName() == "admin.setup") {
                return $next($request);
            }
            else {
                if(Auth::user()->role == 'admin') {
                    return redirect('/admin/setup');
                }
                else {
                    return redirect('/comeback');
                }
            }
            
        }
        elseif($isAnySessionActive) {
            if(Auth::user()->role != 'admin') {
                return $next($request);
            }
           
            $noOfSubjectClassesAssigned = TeacherSubjectClass::where('session_id', active_session()->id)->where('term_id', active_term()->id)->count();
            
            if($noOfSubjectsPerClass <= $noOfSubjectClassesAssigned) {
                $subjectAllocationComplete = 1;
            }
            else {$subjectAllocationComplete = 0;}

            if(!$subjectAllocationComplete) {
                if(Route::currentRouteName() == "admin.setup") {
                return $next($request);
                }
                else {
                    if(Auth::user()->role == 'admin') {
                        return redirect('/admin/setup');
                    }
                    // else {
                    //     return redirect('/comeback');
                    // }
                }
            }
            elseif($subjectAllocationComplete && Route::currentRouteName() == "admin.setup")
            return redirect('/admin/dashboard');
        }
        return $next($request);
    }
}
