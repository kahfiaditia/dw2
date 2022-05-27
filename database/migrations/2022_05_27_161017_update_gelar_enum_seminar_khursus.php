<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGelarEnumSeminarKhursus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->dropColumn('gelar_ijazah');
        });
        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->enum('gelar_ijazah', ['SD', 'SMP', 'SMA', 'SMK', 'Kursus', 'Seminar', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])->nullable()->after('gelar_non_akademik_pendek');
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
            $table->dropColumn('gelar_ijazah');
        });
        Schema::table('ijazah_karyawan', function (Blueprint $table) {
            $table->enum('gelar_ijazah', ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])->nullable()->after('gelar_non_akademik_pendek');
        });
    }
}
