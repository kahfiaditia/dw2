<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllDateReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perpus_pinjaman', function (Blueprint $table) {
            $table->date('all_date_return')->nullable()->after('tgl_kembali');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perpus_pinjaman', function (Blueprint $table) {
            $table->dropColumn('all_date_return');
        });
    }
}
