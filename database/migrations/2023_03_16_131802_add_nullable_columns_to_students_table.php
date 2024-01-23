<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableColumnsToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('medical_condition')->nullable()->after('hours');
            $table->string('medicalcondition_type')->nullable()->after('medical_condition');
            $table->string('medicalcondition_comment')->nullable()->after('medicalcondition_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('medical_condition')->nullable()->after('hours');
            $table->string('medicalcondition_type')->nullable()->after('medical_condition');
            $table->string('medicalcondition_comment')->nullable()->after('medicalcondition_type');
        });
    }
}
