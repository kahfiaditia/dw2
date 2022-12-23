<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahJmlOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uks_stok_obat', function (Blueprint $table) {
            $table->double('jml_out')->default(0)->after('jml');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uks_stok_obat', function (Blueprint $table) {
            $table->dropColumn('jml_out');
        });
    }
}
