<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20);
            $table->string('nik', 20)->nullable();
            $table->string('no_kk', 20);
            $table->string('nama_lengkap', 128);
            $table->enum('jenis_kelamin', ['Laki - Laki', 'Perempuan']);
            $table->string('tempat_lahir', 64);
            $table->date('tanggal_lahir');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O']);
            $table->string('no_registrasi_akta_lahir', 64);
            $table->unsignedBigInteger('agama_id');
            $table->foreign('agama_id')->references('id')->on('agama');
            $table->enum('kewarganegaraan', ['WNA', 'WNI']);
            $table->string('nama_negara', 64);
            $table->unsignedBigInteger('kebutuhan_khusus_id');
            $table->foreign('kebutuhan_khusus_id')->references('id')->on('kebutuhan_khusus');
            $table->softDeletes();
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
        Schema::dropIfExists('siswa');
    }
}
