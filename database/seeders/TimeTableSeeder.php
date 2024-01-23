<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('time_tables')->truncate();
        $old_time_table = DB::connection('mysql2')->table('timetable')->get();

        foreach ($old_time_table as $data) {
            DB::connection('mysql')->table('time_tables')->insert([
                // 'family_id' => 0,
                'student_name'     => $data->studentname,
                'day'     => $data->day,
                'time'     => $data->timeslot,
                'subject'     => $data->subject,
                'family_id'     => $data->admissionid,
            ]);
       }
    }
}
