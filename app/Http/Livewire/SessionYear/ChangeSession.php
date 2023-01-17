<?php

namespace App\Http\Livewire\SessionYear;

use Livewire\Component;

use App\Models\SessionYear;
use App\Models\Term;


class ChangeSession extends Component
{
    public  $session_year_id=1, $term_id=1;

    public function activateSession() {
        // alert("Hi");
        // $this->validate();

        // try {
            SessionYear::query()->update(['active'=>false]);
            $sessionYearID= $this->session_year_id;
            $termID= $this->term_id;
            // session()->flash('success',"g ".$sessionYearID." ".$termID);
            $sessionYear = SessionYear::find($sessionYearID);
            
            $sessionYear->active = true;
            Term::query()->update(['active'=>false]);
            $term = Term::find($termID);
            $term->active = true;
            $sessionYear->save();
            $term->save();
            // // Set flash field
            $this->emit('toast:success', [
                'text' => 'Session & Term Activated Successfully!!',
                'modalID' => "#change_session_modal"
            ]);
            $this->cancel();
        // }
        // catch(\Exception $e){
            // Set Flash Message
            // session()->flash('error','Something goes wrong while activating session!!');
            // $this->resetFields();
        // }

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
