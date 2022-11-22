<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKetersediaanToInvInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventaris', function (Blueprint $table) {
            $table->enum('ketersediaan', ['TERPAKAI', 'TIDAK TERPAKAI', 'DAPAT DIPINJAM']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_inventaris', function (Blueprint $table) {
            $table->dropColumn('ketersediaan');
        });
    }
}
