<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUksKomparasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uks_komparasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_komparasi', 64);
            $table->datetime('tgl_komparasi')->nullable();
            $table->string('kode_opname', 64);
            $table->unsignedBigInteger('id_obat')->nullable();
            $table->foreign('id_obat')->references('id')->on('uks_obat');
            $table->double('stok_opname')->default(0);
            $table->double('stok_sistem')->default(0);
            $table->double('adjust_stok')->default(0);
            $table->unsignedBigInteger('user_opname')->nullable();
            $table->foreign('user_opname')->references('id')->on('users');
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
        Schema::dropIfExists('uks_komparasi');
    }
}
