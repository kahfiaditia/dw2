<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWali extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20);
            $table->string('name');
            $table->date('tanggal_lahir');
            $table->string('email', 128)->nullable();
            $table->string('no_hp', 20);
            $table->string('pendidikan', 128);
            $table->unsignedBigInteger('pekerjaan_id');
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan');
            $table->string('penghasilan');
            $table->enum('type', ['Ayah', 'Ibu', 'Wali']);
            $table->enum('status', ['Orang Tua', 'Wali']);
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->unsignedBigInteger('kebutuhan_khusus_id');
            $table->foreign('kebutuhan_khusus_id')->references('id')->on('kebutuhan_khusus');
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
        Schema::dropIfExists('wali');
    }
}
