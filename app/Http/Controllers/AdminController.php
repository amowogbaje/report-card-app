<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\Result;
use App\Models\TeacherSubjectClass;
use Auth;

class AdminController extends Controller
{
    //
    public function classPage() 
    {
        return view('admin.admin-classes');  
    }

    public function subjects() 
    {
        return view('admin.admin-subjects');
    }

    public function subjectAllocation() {
        return view('admin.subject-allocation');
    }
    
    public function setPaymentStatusNull() {
        Student::where('payment_complete', 1)->update(['payment_complete' => 0, 'payment_token_available' => 0]);
        return "I am going to come";
    }

    public function teachers() 
    {
        return view('admin.admin-teachers');
    }

    public function students() 
    {
        return view('admin.admin-students');
    }

    public function transactions() {
        return view('admin.admin-transactions');
    }

    public function profile(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.admin-profile-page', compact('user'));
    }

    public function editProfile() {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.admin-profile-edit', compact('user'));
    }

    public function updateProfile(Request $request) {
        $user_id = $request->user_id;
        $user = User::find($user_id);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->othernames = $request->othernames;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->lga_origin = $request->lga_origin;
            $user->state_origin = $request->state_origin;
            $user->citizenship = $request->citizenship;
            $user->dob = $request->dob;
            // if($this->dob =="null")
            $user->save();
            if($user) {
                return back()->with('success', $request->firstname.' info has been Successfully edited');
            }
            else {
                return back()->with('error','Something goes wrong while creating category!!');
                // $this->resetFields();
            }
    }

    public function openSessionAndTerm() {
        // Set Active Session
        // Set 
    }

    public function closeSessionAndTerm() {
        // clear all pending transactions

    }

    public function changePasswordPage($id = null) {
        $user_id = $id;
        return view('admin.change-password', compact('user_id'));
    }

    public function changePasswordAction(Request $request) {
        if($request->password != $request->cpassword) {
            return back()->with('error','Passwords do not match!!');
        }
        else {
            $user = User::find($request->user_id);
            $user->password = bcrypt($request->password);
            $user->save();
            if($user->save()) {
                return back()->with('success','Password successfully updated!');
            }
        }
    }

    private function setEnv($key, $value) {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key. '=' . env($value),
            $key. '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    public function setSchoolName() {
        $this->setEnv('SCHOOL_NAME', 'KINGS VISION COLLEGE');
    }

    public function schoolInfo() {
        return view('admin.admin-school-info');
    }
    
    public function updateSubjectId($id, $changedId) {
        TeacherSubjectClass::where('subject_id', $changedId)->update([
            'subject_id' => $id
            ]);
        Result::where('subject_id', $changedId)->update([
            'subject_id' => $id
            ]);
            
        return "subject id adjusted";
        
    }
}
