<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RubahPerawatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uks_perawatan', function (Blueprint $table) {
            $table->dropColumn('deksripsi');
            $table->text('deskripsi')->nullable()->after('gejala');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uks_perawatan', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->text('deksripsi')->nullable()->after('gejala');
        });
    }
}
