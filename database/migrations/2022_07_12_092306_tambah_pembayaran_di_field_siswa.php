<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahPembayaranDiFieldSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('formulir_id')->nullable()->after('class_id');
            $table->foreign('formulir_id')->references('id')->on('payment');
            $table->unsignedBigInteger('pangkal_id')->nullable()->after('formulir_id');
            $table->foreign('pangkal_id')->references('id')->on('payment');
            $table->unsignedBigInteger('spp_id')->nullable()->after('pangkal_id');
            $table->foreign('spp_id')->references('id')->on('payment');
            $table->unsignedBigInteger('kegiatan_id')->nullable()->after('spp_id');
            $table->foreign('kegiatan_id')->references('id')->on('payment');
            $table->boolean('flag_upload')->nullable()->after('kegiatan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['formulir_id']);
            $table->dropColumn('formulir_id');
            $table->dropForeign(['pangkal_id']);
            $table->dropColumn('pangkal_id');
            $table->dropForeign(['spp_id']);
            $table->dropColumn('spp_id');
            $table->dropForeign(['kegiatan_id']);
            $table->dropColumn('kegiatan_id');
            $table->dropColumn('flag_upload');
        });
    }
}
