<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_header', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->dateTime('date_header');
            $table->unsignedBigInteger('siswa_id')->nullable();
            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->double('uang_formulir')->default(0);
            $table->double('uang_pangkal')->default(0);
            $table->unsignedBigInteger('spp_id');
            $table->foreign('spp_id')->references('id')->on('payment');
            $table->double('uang_spp')->default(0);
            $table->unsignedBigInteger('kegiatan_id');
            $table->foreign('kegiatan_id')->references('id')->on('payment');
            $table->double('uang_kegiatan')->default(0);
            $table->unsignedBigInteger('diskon_id')->nullable();
            $table->foreign('diskon_id')->references('id')->on('diskon');
            $table->double('diskon_pembayaran')->default(0);
            $table->unsignedBigInteger('prestasi_id')->nullable();
            $table->foreign('prestasi_id')->references('id')->on('diskon_prestasi');
            $table->double('diskon_prestasi')->default(0);
            $table->double('grand_total')->default(0);
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
        Schema::dropIfExists('invoice_header');
    }
}
