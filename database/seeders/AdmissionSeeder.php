<?php

namespace Database\Seeders;

use App\Models\Admission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::connection('mysql')->table('admissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $old_student_date = DB::connection('mysql2')->table('admission')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('admissions')->insert([
                'id' => $data->admissionid,
                'family_id' => $data->familyno,
                'joining_date' => $data->joiningdate,
                'medical_condition' => $data->medicalcondition,
                'family_status' => $data->familystatus,
                'meeting_detail' => $data->meetingdetail,
            ]);
       }
    }
}
