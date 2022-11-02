<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRuanganToInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventaris', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ruangan');
            $table->foreign('id_ruangan')->references('id')->on('inv_ruangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('inv_inventaris', function (Blueprint $table) {
        //     $table->dropForeign(['id_ruangan']);
        //     $table->dropColumn('id_ruangan');
        // });
    }
}
