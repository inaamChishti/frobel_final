<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('family_id');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('last_payment_date');
            $table->string('paid_up_to_date');
            $table->string('package');
            $table->string('paid');
            $table->string('collector')->nullable();
            $table->string('balance')->nullable();
            $table->longText('comment')->nullable();
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
