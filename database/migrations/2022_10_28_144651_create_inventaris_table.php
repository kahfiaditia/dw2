<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nomor_inventaris', 50);
            $table->string('idbarang', 50);
            $table->string('indikasi', 50)->nullable();
            $table->enum('pemilik', ['Yayasan', 'TK', 'SD', 'SMP', 'SMK']);
            $table->text('deskripsi')->nullable();
            $table->double('qty');
            $table->enum('status', ['Baik', 'Rusak', 'SPEK TIDAK LAYAK']);
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
        Schema::dropIfExists('inventaris');
    }
}
