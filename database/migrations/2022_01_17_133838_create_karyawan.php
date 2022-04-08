<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 128);
            $table->string('tempat_lahir', 64);
            $table->date('tgl_lahir');
            $table->unsignedBigInteger('agama_id')->nullable();
            $table->foreign('agama_id')->references('id')->on('agama');
            $table->string('nik', 20);
            $table->string('dok_nik', 64)->nullable();
            $table->string('npwp', 20)->nullable();
            $table->string('dok_npwp', 64)->nullable();
            $table->string('kk', 20);
            $table->string('dok_kk', 64)->nullable();
            $table->string('bpjs_kesehatan', 20)->nullable();
            $table->string('bpjs_ketenagakerjaan', 20)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('nama_pasangan', 64)->nullable();
            $table->string('no_pasangan', 64)->nullable();
            // kontak darurat
            // alamat asli
            $table->string('provinsi_asal', 64)->nullable();
            $table->string('kota_asal', 64)->nullable();
            $table->string('kecamatan_asal', 64)->nullable();
            $table->string('kelurahan_asal', 64)->nullable();
            $table->string('kodepos_asal', 5)->nullable();
            $table->text('dusun_asal')->nullable();
            $table->string('rt_asal', 64)->nullable();
            $table->string('rw_asal', 64)->nullable();
            $table->text('alamat_asal')->nullable();
            // alamat di tangerang
            $table->string('provinsi', 64)->nullable();
            $table->string('kota', 64)->nullable();
            $table->string('kecamatan', 64)->nullable();
            $table->string('kelurahan', 64)->nullable();
            $table->string('kodepos', 5)->nullable();
            $table->text('dusun')->nullable();
            $table->string('rt', 64)->nullable();
            $table->string('rw', 64)->nullable();
            $table->text('alamat')->nullable();
            // ijazah
            // SK
            // jml anak
            $table->string('jabatan', 25)->nullable();
            $table->date('masuk_kerja')->nullable();
            // anak sekolah di DW + jenjang
            // riwayat penyakit
            $table->string('aktif', 1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
}
