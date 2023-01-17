<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use DB;
// use App\Models\ClassLevel;
// use App\Models\Student;
use App\Jobs\ImportStudentFromSheet;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  protected $class_id;

    public function __construct($class_id) {
        $this->class_id = $class_id;
    }
  
    public function collection(Collection $rows)
    {
        //
        ImportStudentFromSheet::dispatch($this->class_id, $rows);
    }


    // public function headingRow(): array
    // {
    //     return [
    //         "Firstname", "Lastname", "Othernames",
    //         "Email", "Phone", "Date of Birth",
    //         "Gender", "Citizenship",
    //         "State of Origin", "Local Government", "Guardian Name",
    //         "Guardian Address", "Guardian Phone", "Category"
    //     ];
    // }
}
