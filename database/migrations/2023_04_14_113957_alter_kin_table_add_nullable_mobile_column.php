<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKinTableAddNullableMobileColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kin', function (Blueprint $table) {
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kin', function (Blueprint $table) {
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
        });
    }
}
