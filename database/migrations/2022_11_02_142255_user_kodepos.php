<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserKodepos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kodepos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_created')->nullable()->after('status');
            $table->foreign('user_created')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated')->nullable()->after('user_created');
            $table->foreign('user_updated')->references('id')->on('users');
            $table->unsignedBigInteger('user_deleted')->nullable()->after('user_updated');
            $table->foreign('user_deleted')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kodepos', function (Blueprint $table) {
            $table->dropForeign(['user_created']);
            $table->dropColumn('user_created');
            $table->dropForeign(['user_updated']);
            $table->dropColumn('user_updated');
            $table->dropForeign(['user_deleted']);
            $table->dropColumn('user_deleted');
        });
    }
}
