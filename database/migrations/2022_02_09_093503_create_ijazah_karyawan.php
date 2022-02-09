<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIjazahKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ijazah_karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('instansi', 64)->nullable(false);
            $table->string('jurusan', 64)->nullable(false);
            $table->year('tahun_masuk');
            $table->year('tahun_lulus');
            $table->enum('gelar_ijazah', ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])->nullable();
            $table->string('gelar_akademik_panjang', 64)->nullable();
            $table->string('gelar_akademik_pendek', 64)->nullable();
            $table->string('gelar_non_akademik_panjang', 64)->nullable();
            $table->string('gelar_non_akademik_pendek', 64)->nullable();
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
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
        Schema::dropIfExists('ijazah_karyawan');
    }
}
