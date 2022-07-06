<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JenjangKelasDirubahJadiIdTableSchollLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('jenjang');
            $table->dropColumn('class');
            $table->unsignedBigInteger('id_school_level')->nullable()->after('id');
            $table->foreign('id_school_level')->references('id')->on('school_level');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->string('class', 64)->after('jurusan')->nullable();
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
            $table->string('jenjang', 64)->nullable()->after('id');
            $table->dropColumn('class');
            $table->dropForeign(['id_school_level']);
            $table->dropColumn('id_school_level');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->string('class', 64);
        });
    }
}
