<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $old_user = DB::connection('mysql2')->table('subjects')->get();

        foreach ($old_user as $user) {
            DB::connection('mysql')->table('subjects')->insert([
                'name' => $user->name
            ]);
        }
    }
}
