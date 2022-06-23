<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKesejahteraanSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesejahteraan_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kesejahteraan');
            $table->string('nomor_kartu');
            $table->string('nama_kartu');
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kesejahteraan_siswa');
    }
}
