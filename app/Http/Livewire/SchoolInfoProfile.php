<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\SchoolInfo;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use Livewire\WithFileUploads;

class SchoolInfoProfile extends Component
{
    use WithFileUploads;
    public $schoolInfo, $pics, $name, $codename, $stamp_img_url, $address, $type, $school_colors, $setup_complete, $readonly = "";
    
    public function updateSchoolColor($hex) {
        $this->school_colors = $hex;
    }
    public function update() {
        $updateSchoolInfo = SchoolInfo::find(school_info()->id);
        $updateSchoolInfo->name = $this->name;
        $updateSchoolInfo->codename = $this->codename;
        $updateSchoolInfo->address = $this->address;
        $updateSchoolInfo->type = $this->type;
        $updateSchoolInfo->setup_complete = true;
        $updateSchoolInfo->save();
        $this->mount();
        $this->render();
        $this->emit('toast:success', [
            'text' => "Your School Info has been updated",
            'modalID' => "#behaviour_assessment_modal"
        ]);
        // $updateSchoolInfo->address = $this->address;
        // $updateSchoolInfo->
    }

    public function uploadPics() {
        // $param = $this->validate([
        //     'pics' => 'image|mimes:png,jpg|max:102400'
        // ]);
        // sleep(3);
        $updateSchoolInfo = SchoolInfo::find(school_info()->id);
        $oldfile = school_info()->stamp_img_url;
        $fileName = $this->pics->store('profile-pics/school-info', 'public_uploads');
        

        $updateSchoolInfo->school_colors = $this->school_colors;
        $updateSchoolInfo->stamp_img_url = $fileName;
        $updateSchoolInfo->save();
        // $absolutePath = url('/uploads/'.$fileName);
        
        // $colorFromImage = json_encode(getColorFromImage($absolutePath));
        // $updateSchoolInfo->school_colors = ($colorFromImage);
        // unlink($oldfile);
        Storage::disk('public_uploads')->delete($oldfile);
        $this->emit('toast:success', [
            'text' => "School logo has been updated".$this->school_colors,
            'modalID' => "#behaviour_assessment_modal"
        ]);
        $this->mount();
        $this->render();
    }

    public function mount() {
        $this->schoolInfo = school_info();
        $this->name = school_info()->name;
        $this->codename = school_info()->codename;
        $this->address = school_info()->address;
        $this->type = school_info()->type;
        $this->setup_complete = school_info()->setup_complete;
        if(school_info()->setup_complete) {$this->readonly = "disabled";}
    }

    

    public function render()
    {
        return view('livewire.school-info-profile');
    }
}
