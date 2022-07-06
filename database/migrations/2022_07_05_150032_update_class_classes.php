<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('class');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('jurusan');
            $table->foreign('class_id')->references('id')->on('school_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->string('class', 64)->after('jurusan')->nullable();
        });
    }
}
