<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('family_id');
            $table->string('guardian_id');
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('telNo1')->nullable();
            $table->string('telAlter1')->nullable();
            $table->string('telNo2')->nullable();
            $table->string('telAlter2')->nullable();
            $table->string('drName')->nullable();
            $table->string('drTel')->nullable();
            $table->string('drAddress')->nullable();
            $table->string('yes')->nullable();
            $table->string('no')->nullable();
            $table->string('currentMedical')->nullable();
            $table->string('athome')->nullable();
            $table->string('athomeSchl')->nullable();
            $table->string('studentAdmin')->nullable();
            $table->string('staffAdmin')->nullable();
            $table->string('studentAdminSuper')->nullable();
            $table->string('otherRadio')->nullable();
            $table->string('otherDetails')->nullable();
            $table->string('commenAdmin')->nullable();
            $table->string('dietry')->nullable();
            $table->string('sign')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('medical_conditions');
    }
}
