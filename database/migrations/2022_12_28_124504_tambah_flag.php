<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uks_komparasi', function (Blueprint $table) {
            $table->string('type_adjust', 10)->nullable()->after('adjust_stok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uks_komparasi', function (Blueprint $table) {
            $table->dropColumn('type_adjust');
        });
    }
}
