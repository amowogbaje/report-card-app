<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SessionYear;

class Setup extends Component
{
    public $noSessionAtAll, $currentSession;
    public function mount() {
        $countSession = SessionYear::count();
        if($countSession == 0) {
            $this->noSessionAtAll = 1;
        }
        else {
            $this->noSessionAtAll = 0;
        }
        $activeSession = SessionYear::where('active', 1)->count();
        if($activeSession == 0) {
            $this->currentSession = SessionYear::latest()->first();
        }
        else {
            $this->currentSession = SessionYear::where('active', 1)->first();
        }
        
    }

    public function getNextSession($current) {
        $year = explode("/", $current)[1];
        $next = intval($year)+1;
        $nextSession = $year."/".$next;
        return $nextSession;
    }

    public function createNextSession() {
        SessionYear::query()->update(['active'=>false]);
        $lastSession = SessionYear::latest()->first();
        $nextSession = $this->getNextSession($lastSession->name);
        SessionYear::create([
            'name' => $nextSession
        ]);
        // session()->flash('success',"g ".$sessionYearID." ".$termID);
        
        // // Set flash field
        $this->emit('toast:success', [
            'text' => 'Session Created Successfully!!',
            // 'modalID' => "#change_session_modal"
        ]);
        $this->clear();
    }

    public function clear() {
        $this->mount();
        $this->render();
    }

    public function render()
    {
        return view('livewire.setup');
    }
}
