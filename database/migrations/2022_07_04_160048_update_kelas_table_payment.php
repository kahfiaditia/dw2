<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKelasTablePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            $table->year('year_end')->nullable()->after('year');
            $table->unsignedBigInteger('school_level_id')->nullable()->after('bills_id');
            $table->foreign('school_level_id')->references('id')->on('school_level');
        });
        Schema::table('payment', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('school_level_id');
            $table->foreign('class_id')->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropForeign(['school_level_id']);
            $table->dropColumn('school_level_id');
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            $table->dropColumn('year_end');
        });
        Schema::table('payment', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('bills_id');
            $table->foreign('class_id')->references('id')->on('classes');
        });
    }
}
