<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnakKarSklhDw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anak_kar_sklh_dw', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anak_id');
            $table->foreign('anak_id')->references('id')->on('anak_karyawan');
            $table->enum('jenjang', ['KB', 'TK', 'SD', 'SMP', 'SMK'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anak_kar_sklh_dw');
    }
}
