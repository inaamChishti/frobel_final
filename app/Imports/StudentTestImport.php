<?php

namespace App\Imports;

use App\Models\StudentTest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class   StudentTestImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        if(!array_filter($row)) { return null;}
        $date = null;

        if (is_int($row[5])) {
            $date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]));

        }

        return new StudentTest([
            'family_id' => intval($row[0]),
            'student_name' => $row[1],
            'book' => $row[2],
            'test_no' => $row[3],
            'attempt' => $row[4],
            'date' => $date,
            'percentage' => $row[6],
            'status' => $row[7],
            'subject' => $row[8],
            'tutor' => $row[9],
            'updated_by' => $row[10],

        ]);
    }
}
