<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\User;
use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Result;
use App\Models\ClassLevel;
use Auth;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index() {
        $userId = Auth::user()->id;
        return view('students.student-transactions', compact('userId'));
    }

}
