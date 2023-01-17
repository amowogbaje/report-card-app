<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplateExport implements FromCollection, WithHeadings
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
            'users.dob',
            'users.gender',
            'users.citizenship',
            'users.state_origin',
            'users.lga_origin',
            'students.guardian_name',
            'students.guardian_address',
            // 'class_levels.shortname'

        ];
        $students = DB::table('students')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->join('class_levels', 'students.class_id', '=', 'class_levels.id');
        $students = $students->take(0)->get($selectedColumns);
        
        
        return $students;
    }

    public function headings(): array
    {
        return [
            "Firstname", "Lastname", "Othernames",
            "Email", "Phone", "Date of Birth",
            "Gender", "Citizenship",
            "State of Origin", "Local Government", "Guardian Name",
            "Guardian Address"
        ];
    }
}
