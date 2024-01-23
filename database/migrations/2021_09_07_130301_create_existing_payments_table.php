<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExistingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existing_payments', function (Blueprint $table) {
            $table->id();
            $table->string('family_id');
            $table->string('from');
            $table->string('to');
            $table->string('date');
            $table->string('package');
            $table->string('paid');
            $table->string('balance');
            $table->string('payment_method')->nullable();
            $table->string('collector')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('existing_payments');
    }
}
