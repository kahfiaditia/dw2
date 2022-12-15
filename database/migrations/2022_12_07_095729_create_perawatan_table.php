<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerawatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uks_perawatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perawatan', 64);
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->foreign('id_siswa')->references('id')->on('siswa');
            $table->unsignedBigInteger('id_obat')->nullable();
            $table->foreign('id_obat')->references('id')->on('uks_obat');
            $table->unsignedBigInteger('id_stok_obat');
            $table->foreign('id_stok_obat')->references('id')->on('uks_stok_obat');
            $table->double('qty');
            $table->date('tgl');
            $table->timestamp('masuk')->nullable();
            $table->timestamp('keluar')->nullable();
            $table->string('gejala', 100)->nullable();
            $table->text('deksripsi')->nullable();
            $table->unsignedBigInteger('user_created')->nullable();
            $table->foreign('user_created')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated')->nullable();
            $table->foreign('user_updated')->references('id')->on('users');
            $table->unsignedBigInteger('user_deleted')->nullable();
            $table->foreign('user_deleted')->references('id')->on('users');
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
        Schema::dropIfExists('uks_perawatan');
    }
}
