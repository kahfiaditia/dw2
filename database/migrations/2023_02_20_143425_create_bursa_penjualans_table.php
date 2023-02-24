<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursaPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bursa_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penjualan', 64);
            $table->double('total')->nullable();
            $table->double('total_modal')->nullable();
            $table->double('total_margin')->nullable();
            $table->double('total_produk')->nullable();
            $table->string('keterangan', 40)->nullable();
            $table->integer('status_pembayaran')->nullable();
            $table->integer('jenis_pembayaran')->nullable();
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->foreign('id_siswa')->references('id')->on('siswa');
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
        Schema::dropIfExists('bursa_penjualans');
    }
}
