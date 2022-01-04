<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pin_verified', 4)->nullable()->after('email');
            $table->timestamp('pin_verified_at')->nullable()->after('pin_verified');
            $table->string('roles', 15)->nullable()->after('password');
            $table->timestamp('password_reset_at')->nullable()->after('password');
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
            $table->dropColumn('pin_verified');
            $table->dropColumn('pin_verified_at');
            $table->dropColumn('roles');
            $table->dropColumn('password_reset_at');
        });
    }
}
