<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKaryawanToBursaPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bursa_penjualans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_karyawan')->nullable()->after('id_siswa');
            $table->foreign('id_karyawan')->references('id')->on('karyawan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bursa_penjualans', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
            $table->dropColumn('id_karyawan');
        });
    }
}
