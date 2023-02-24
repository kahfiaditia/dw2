<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursaPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bursa_pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 64);
            $table->timestamp('tgl_permintaan')->nullable();
            $table->timestamp('tgl_kedatangan')->nullable();
            $table->string('nomor_do', 64)->nullable();
            $table->unsignedBigInteger('id_supplier');
            $table->foreign('id_supplier')->references('id')->on('bursa_suppliers');
            $table->double('total_produk')->nullable();
            $table->double('ongkir')->nullable();
            $table->double('total_nilai')->nullable();
            $table->double('potongan')->nullable();
            $table->string('keterangan', 40)->nullable();
            $table->integer('status_pembayaran')->nullable();
            $table->integer('tgl_pembayaran')->nullable();
            $table->integer('jenis_pembayaran')->nullable();
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
        Schema::dropIfExists('bursa_pembelians');
    }
}
