<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassSchoolPayment extends Migration
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
            $table->unsignedBigInteger('school_class_id')->nullable()->after('school_level_id');
            $table->foreign('school_class_id')->references('id')->on('school_class');
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
            $table->unsignedBigInteger('class_id')->nullable()->after('school_level_id');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->dropForeign(['school_class_id']);
            $table->dropColumn('school_class_id');
        });
    }
}
