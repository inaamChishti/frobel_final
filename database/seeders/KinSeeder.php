<?php

namespace Database\Seeders;

use App\Models\Kin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('kin')->truncate();
        $old_student_date = DB::connection('mysql2')->table('kin')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('kin')->insert([
                'id' => $data->kinid,
                'name' => $data->kinname,
                'email' => '',
                'address' => $data->kinaddress,
                'mobile' => $data->kinmob,
            ]);
       }
    }

}
