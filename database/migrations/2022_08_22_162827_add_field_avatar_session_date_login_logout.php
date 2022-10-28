<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldAvatarSessionDateLoginLogout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar', 64)->nullable()->after('remember_token');
            $table->string('session', 128)->nullable()->after('avatar');
            $table->dateTime('date_login')->nullable()->after('session');
            $table->dateTime('date_logout')->nullable()->after('date_login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('session');
            $table->dropColumn('date_login');
            $table->dropColumn('date_logout');
        });
    }
}
