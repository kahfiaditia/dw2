<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahFieldAkademi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->string('type', 64)->nullable()->after('id');
            $table->dropColumn('tahun_masuk');
            $table->dropColumn('tahun_lulus');
            $table->dropColumn('jurusan');
            $table->dropColumn('nama_pendidikan');
        });

        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->year('tahun_masuk')->nullable()->after('type');
            $table->year('tahun_lulus')->nullable()->after('tahun_masuk');
            $table->string('jurusan', 64)->nullable()->after('tahun_lulus');
            $table->string('nama_pendidikan', 128)->nullable()->after('instansi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->dropColumn('tahun_masuk');
            $table->dropColumn('tahun_lulus');
            $table->dropColumn('jurusan');
            $table->dropColumn('nama_pendidikan');
        });

        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->year('tahun_masuk')->nullable(false)->after('id');
            $table->year('tahun_lulus')->nullable(false)->after('tahun_masuk');
            $table->string('jurusan', 64)->nullable(false)->after('tahun_lulus');
            $table->string('nama_pendidikan', 128)->nullable(false)->after('instansi');
        });
    }
}
