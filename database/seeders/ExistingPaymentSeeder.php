<?php

namespace Database\Seeders;

use App\Models\ExistingPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExistingPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('payments')->truncate();
        $old_student_date = DB::connection('mysql2')->table('payment')->get();

        foreach ($old_student_date as $data) {
            DB::connection('mysql')->table('payments')->insert([
                'family_id' => $data->paymentfamilyid,
                'from' => $data->paymentfrom,
                'to' => $data->paymentto,
                'paid_up_to_date' => $data->paymentto,
                'last_payment_date' => $data->paymentdate,
                'package' => $data->package,
                'paid' => $data->paid,
                'balance' => $data->balance,
                'payment_method' => $data->payment_method,
                'collector' => $data->collector,

            ]);
       }
    }
}
