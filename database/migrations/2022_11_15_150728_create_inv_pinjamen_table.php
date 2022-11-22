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
            $table->unsignedBigInteger('nama_peminjam');
            $table->foreign('nama_peminjam')->references('id')->on('users');
            $table->date('tgl_pemakaian');
            $table->date('tgl_permintaan');
            $table->date('estimasi_kembali');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('inv_inventaris');
            $table->double('jumlah')->nullable();
            $table->string('diberikan_oleh', 64)->nullable();
            $table->date('tgl_diberikan')->nullable();
            $table->enum('barang_kembali', ['Baik', 'Lecet', 'Rusak'])->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->string('deskripsi', 100)->nullable()->nullable();
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
