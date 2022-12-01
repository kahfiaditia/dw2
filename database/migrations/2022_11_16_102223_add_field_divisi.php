<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDivisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('divisi', 64)->nullable()->after('jabatan');
            $table->date('tgl_resign')->nullable()->after('divisi');
            $table->text('alasan_resign')->nullable()->after('tgl_resign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('divisi');
            $table->dropColumn('tgl_resign');
            $table->dropColumn('alasan_resign');
        });
    }
}
