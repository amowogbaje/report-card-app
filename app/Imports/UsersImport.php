<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $user_role;

    public function __construct($user_role) {
        $this->user_role = $user_role;
    }

    public function model(array $row)
    {
        if($this->user_role == 'student') {
            return new User([
                'firstname' => $row['Firstname'],
            ]);
        }
        
    }
}
