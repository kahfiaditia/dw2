<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldNisJadiNiksKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // composer require doctrine/dbal (harus instal composer dbal)
        Schema::table('karyawan', function (Blueprint $table) {
            $table->renameColumn('nis', 'niks');
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
            $table->renameColumn('niks', 'nis');
        });
    }
}
