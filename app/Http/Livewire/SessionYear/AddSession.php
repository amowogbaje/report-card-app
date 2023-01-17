<?php

namespace App\Http\Livewire\SessionYear;

use App\Models\SessionYear;

use Livewire\Component;

class AddSession extends Component
{

    public $name;

    public function mount() {
        // $this->$sessionYear = $sessionYear;
    }

    public function resetFields(){
        $this->name = '';
    }
    public function testing() {
        alert("Hi");
        return redirect('/');
    }

    public function closeModal() {

    }

    public function store() {
        // alert("Hi");
        // $this->validate();

        try {
            $year = date('Y');
            // $name = 
            SessionYear::create([
                'name' => $this->name
            ]);
            // Set flash field
            // session()->flash('success','Session Created Successfully!!');
            $this->emit('toast:success', [
                'text' => 'Session Created Successfully!!',
                'modalID' => "#add_session_modal"
            ]);
            $this->cancel();
        }
        catch(\Exception $e){
            // Set Flash Message
            $this->emit('toast:failure', [
                'text' => 'Something goes wrong while creating category!!',
                'modalID' => "#add_session_modal"
            ]);
            $this->cancel();
        }
        // $this->closeModal()
    }

    public function cancel() {
        $this->resetFields();
        $this->mount();
        $this->render();
    }

    public function render()
    {
        return view('livewire.session-year.add-session');
    }
}
