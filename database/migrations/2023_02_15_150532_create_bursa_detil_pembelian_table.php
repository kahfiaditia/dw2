<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursaDetilPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bursa_detil_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembelian');
            $table->foreign('id_pembelian')->references('id')->on('bursa_pembelians');
            $table->timestamp('kadaluarsa');
            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id')->on('bursa_produks');
            $table->double('harga_total_produk')->nullable();
            $table->double('total_kuantiti')->nullable();
            $table->double('nilai_per_pcs')->nullable();
            $table->double('nilai_jual')->nullable();
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
        Schema::dropIfExists('bursa_detil_pembelian');
    }
}
