<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriodikSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priodik_siswa', function (Blueprint $table) {
            $table->id();
            $table->float('tinggi_badan', 8, 2);
            $table->float('berat_badan', 8, 2);
            $table->float('lingkar_kepala', 8, 2);
            $table->string('jarak_tempat_tinggal_ke_sekolah');
            $table->float('in_km', 8, 2);
            $table->float('waktu_tempuh_jam', 8, 2);
            $table->float('waktu_tempuh_menit', 8, 2);
            $table->string('jumlah_saudara_kandung', 10);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priodik_siswa');
    }
}
