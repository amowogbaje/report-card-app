<?php

namespace App\Exports;

use App\Models\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $selectedColumns = [
            'users.firstname',
            'users.lastname',
            'users.othernames',
            'users.email',
            'users.phone',
            'users.address',
            'users.gender',
            'users.citizenship',
            'users.state_origin',
            'users.lga_origin',

        ];
        $teachers = DB::table('teachers')
                    ->join('users', 'teachers.user_id', '=', 'users.id')
                    ->take(0)->get($selectedColumns);
        
        
        return $teachers;
    }

    public function headings(): array
    {
        return [
            "Firstname", "Lastname", "Othernames",
            "Email", "Phone",
            "Address", "Gender", "Citizenship",
            "State of Origin", "Local Government"
        ];
    }
}
