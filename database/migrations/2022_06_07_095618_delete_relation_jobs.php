<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteRelationJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wali', function (Blueprint $table) {
            $table->dropForeign(['pekerjaan_id']);
            $table->dropColumn('pekerjaan_id');
            $table->string('pekerjaan')->after('pendidikan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wali', function (Blueprint $table) {
            $table->dropColumn('pekerjaan');
            $table->unsignedBigInteger('pekerjaan_id')->nullable();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan');
        });
    }
}
