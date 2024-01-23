<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Role::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TimeTableSeeder::class,
            StudentSeeder::class,
            GuardianSeeder::class,
            KinSeeder::class,
            AdmissionSeeder::class,
            AttendanceSeeder::class,
            ExistingPaymentSeeder::class,
            SubjectSeeder::class
        ]);
    }
}
