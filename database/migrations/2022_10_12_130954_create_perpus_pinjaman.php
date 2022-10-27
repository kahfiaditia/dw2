<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpusPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpus_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 64);
            $table->string('milisecond', 64);
            $table->string('peminjam', 25);
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
            $table->unsignedBigInteger('class_id')->nullable(); // kelas
            $table->foreign('class_id')->references('id')->on('classes');
            $table->unsignedBigInteger('buku_id'); // buku
            $table->foreign('buku_id')->references('id')->on('perpus_buku');
            $table->double('jml')->default(0);
            $table->date('tgl_pinjam')->nullable();
            $table->date('tgl_perkiraan_kembali')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->unsignedBigInteger('user_created')->nullable();
            $table->foreign('user_created')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated')->nullable();
            $table->foreign('user_updated')->references('id')->on('users');
            $table->unsignedBigInteger('user_deleted')->nullable();
            $table->foreign('user_deleted')->references('id')->on('users');
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
        Schema::dropIfExists('perpus_pinjaman');
    }
}
