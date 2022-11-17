<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvPinjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 64);
            $table->enum('status_transaksi', ['Proses', 'Penyerahan', 'Selesai', 'Ditolak']);
            $table->unsignedBigInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id')->on('karyawan');
            $table->date('tgl_pemakaian');
            $table->date('tgl_permintaan');
            $table->date('estimasi_kembali');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('inv_inventaris');
            $table->enum('status_barang1', ['Baik', 'Lecet', 'Rusak']);
            $table->string('qty', 4);
            $table->string('deskripsi', 100)->nullable();
            $table->unsignedBigInteger('user_created');
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
        Schema::dropIfExists('inv_pinjaman');
    }
}
