<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

use App\Models\Teacher;
use App\Models\User;
use App\Models\ClassLevel;
use App\Models\TeacherSubjectClass;
use App\Models\SessionYear;
use App\Models\Term;


use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class TeacherProfile extends Component
{
    use WithFileUploads;
    public $profileId, $pics, $signature_url, $signature;

    public function assignClass() {
        session()->flash('error','Something goes wrong while creating category!!');
    }
    public function uploadPics() {
        // $param = $this->validate([
        //     'pics' => 'image|mimes:png,jpg|max:102400'
        // ]);
        sleep(10);
        $user = User::where('id',$this->profileId)->first();
        $updateUserInfo = User::find($this->profileId);
        // $oldfile = $user->profile_pics;
        $fileName = $this->pics->store('profile-pics/teachers', 'public_uploads');
        $updateUserInfo->profile_pics = $fileName;
        $updateUserInfo->save();
        // unlink($oldfile);
        // Storage::disk('public_uploads')->delete($oldfile);
        $this->emit('toast:success', [
            'text' => "Your Profile has been updated: ",
            'modalID' => "#behaviour_assessment_modal"
        ]);
        $this->mount();
        $this->render();
    }
    
    public function uploadSignature() {
        sleep(10);
        // $user = User::where('id',$this->signature_url)->first();
        $updateUserInfo = User::find($this->profileId);
        // $oldfile = $user->signature_url;
        $fileName = $this->signature->store('signatures', 'public_uploads');
        $updateUserInfo->signature_url = $fileName;
        $updateUserInfo->save();
        // unlink($oldfile);
        // Storage::disk('public_uploads')->delete($oldfile);
        $this->emit('toast:success', [
            'text' => "Your Signature has been uploaded: ",
            'modalID' => "#behaviour_assessment_modal"
        ]);
        $this->mount();
        $this->render();
    }

    public function render()
    {
        $classlevels = ClassLevel::all();
        $teacher = Teacher::where('user_id', $this->profileId)->first();
        $current_session_id = active_session()->id;
        $current_term_id = active_term()->id;
        $teacherSubjectClassObject = TeacherSubjectClass::where('teacher_id', $teacher->id)
                                        ->where('session_id', $current_session_id)
                                        ->where('term_id', $current_term_id);
        $noOfSubjects = $teacherSubjectClassObject->count();
        $subjectAndClasses = $teacherSubjectClassObject->get();
        return view('livewire.teacher.teacher-profile', compact('teacher', 'classlevels', 'noOfSubjects', 'subjectAndClasses'));
    }
}
