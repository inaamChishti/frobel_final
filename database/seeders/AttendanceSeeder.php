<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('attendances')->truncate();
        $old_student_date = DB::connection('mysql2')->table('attendance')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('attendances')->insert([
                'family_id' => $data->family_id,
                'student_name' => $data->student_name,
                'years_in_school' => $data->student_year_in_school,
                'bk_ch' => $data->bk_ch,
                'status' => $data->status,
                'date' => $data->date,
                'teacher' => $data->teacher_name,
                'subject' => $data->subject,
                'time' => $data->time_slot,
                'session' => $data->session_1,
            ]);
       }
    }
}
