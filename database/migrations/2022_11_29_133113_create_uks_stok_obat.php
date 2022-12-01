<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUksStokObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uks_stok_obat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 64);
            $table->date('tgl_ed')->nullable();
            $table->unsignedBigInteger('id_obat')->nullable();
            $table->foreign('id_obat')->references('id')->on('uks_obat');
            $table->double('jml')->default(0);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('uks_stok_obat');
    }
}
