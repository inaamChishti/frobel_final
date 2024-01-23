<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('family_id');
            $table->string('student_name');
            $table->string('subject')->nullable();
            $table->string('book')->nullable();
            $table->string('test_no')->nullable();
            $table->string('attempt')->nullable();
            $table->date('date')->nullable();
            $table->string('percentage')->nullable();
            $table->string('status')->nullable();
            $table->string('tutor_updated_by')->nullable();

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
        Schema::dropIfExists('student_tests');
    }
}
