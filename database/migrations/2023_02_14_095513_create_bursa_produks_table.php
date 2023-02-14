<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursaProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bursa_produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id')->on('bursa_satuans');
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')->references('id')->on('bursa_kategoris');
            $table->string('barcode', 15)->nullable();
            $table->string('nama', 40);
            $table->string('deskripsi', 64)->nullable();
            $table->double('stok_minimal')->nullable();
            $table->double('stok')->nullable();
            $table->double('harga_beli')->nullable();
            $table->double('harga_jual')->nullable();
            $table->integer('status');
            $table->timestamp('kadaluarsa')->nullable();
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
        Schema::dropIfExists('bursa_produks');
    }
}
