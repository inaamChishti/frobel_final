<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('guardians')->truncate();
        $old_student_date = DB::connection('mysql2')->table('guardian')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('guardians')->insert([
                'id' => $data->Guardianid,
                'name' => $data->guardianname,
                'email' => '',
                'telephone' => $data->guardiantel,
                'mobile' => $data->guardianmob,
                'address' => $data->guardianaddress,
            ]);
       }
    }
}
