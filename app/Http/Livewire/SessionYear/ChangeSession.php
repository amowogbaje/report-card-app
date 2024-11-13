<?php

namespace App\Http\Livewire\SessionYear;

use Livewire\Component;

use App\Models\SessionYear;
use App\Models\Term;
use App\Models\Student;
use App\Models\TeacherSubjectClass;
use DB;

use App\Jobs\ActiveResultForStudent;


class ChangeSession extends Component
{
    public  $session_year_id, $term_id=1;

    public function getNextSession($current) {
        $year = explode("/", $current)[1];
        $next = intval($year)+1;
        $nextSession = $year."/".$next;
        return $nextSession;
    }

    public function mount() {
        $this->session_year_id = SessionYear::latest()->first()->id;
    }
    
    public function setPaymentStatusNull() {
        Student::where('payment_complete', 1)->update(['payment_complete' => 0, 'payment_token_available' => 0]);
        return "I am going to come";
    }

    public function activateSession() {
        // alert("Hi");
        // $this->validate();

        // try {
            
            SessionYear::query()->update(['active'=>false]);
            $sessionYearID= $this->session_year_id;
            $termID= $this->term_id;
            // session()->flash('success',"g ".$sessionYearID." ".$termID);
            $sessionYear = SessionYear::find($sessionYearID);
            $this->setPaymentStatusNull();
            $sessionYear->active = true;
            Term::query()->update(['active'=>false]);
            $term = Term::find($termID);
            $term->active = true;
            $sessionYear->save();
            $term->save();
            // Set flash field
            $students = Student::where('status', 1)->get();
            ActiveResultForStudent::dispatch($students);
            $this->generateOtp();
            $this->emit('toast:success', [
                'text' => 'Session & Term Activated Successfully!!',
                'modalID' => "#change_session_modal"
            ]);

            
            return redirect(request()->header('Referer'));
        // }
        // catch(\Exception $e){
            // Set Flash Message
            // session()->flash('error','Something goes wrong while activating session!!');
            // $this->resetFields();
        // }

    }

    public function closeSectionAndTerm() {
        session([
                'last_term_id' => active_term()->id,
                'last_session_id' => active_session()->id,
                ]);
        SessionYear::query()->update(['active'=>false]);
        Term::query()->update(['active'=>false]);
        return redirect('/setup');

    }
    

    public function createNextSession() {
        SessionYear::query()->update(['active'=>false]);
        $lastSession = SessionYear::latest()->first();
        $nextSession = $this->getNextSession($lastSession);
        SessionYear::create([
            'name' => $nextSession
        ]);
        
        // session()->flash('success',"g ".$sessionYearID." ".$termID);
        
        // // Set flash field
        $this->emit('toast:success', [
            'text' => 'Session Created Successfully!!',
            'modalID' => "#change_session_modal"
        ]);
        $this->cancel();
    }

    public function generateOtp() {
        $students = Student::all();
        foreach($students as $student) {
            DB::table('payment_codes')->insert([
                'session_id' => active_session()->id,
                'term_id' => active_term()->id,
                'student_id' => $student->id,
                'payment_verification_code' => FLOOR(RAND() * 401) + 100
            ]);
        }

        $this->emit('toast:success', [
            'text' => 'OTP Generated Successfully!!',
            'modalID' => "#change_session_modal"
        ]);
    }

    public function cancel() {
        // $this->resetFields();
        $this->mount();
        $this->render();
    }

    
    public function render()
    {
        $sessionYears = SessionYear::all();
        $terms = Term::all();
        return view('livewire.session-year.change-session', compact('sessionYears', 'terms'));
    }
}
