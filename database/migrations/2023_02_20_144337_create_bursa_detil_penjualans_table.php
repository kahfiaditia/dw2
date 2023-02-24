<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursaDetilPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bursa_detil_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->foreign('id_penjualan')->references('id')->on('bursa_penjualans');
            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id')->on('bursa_produks');
            $table->double('kuantiti')->nullable();
            $table->double('harga_jual')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('harga_modal')->nullable();
            $table->double('sub_modal')->nullable();
            $table->double('margin_produk')->nullable();
            $table->double('sub_margin')->nullable();
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
        Schema::dropIfExists('bursa_detil_penjualans');
    }
}
