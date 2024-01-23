<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('students')->truncate();
        $old_student_date = DB::connection('mysql2')->table('studentdata')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('students')->insert([
                'name' => $data->studentname,
                'surname' => $data->studentsur,
                'dob' => $data->studentdob,
                'gender' => $data->studentgender,
                'years_in_school' => $data->studentyearinschool,
                'hours' => $data->studenthours,
                'guardian_id' => $data->guardianid,
                'kin_id' => $data->kinid,
                'admission_id' => $data->admissionid,
            ]);
       }
    }
}
