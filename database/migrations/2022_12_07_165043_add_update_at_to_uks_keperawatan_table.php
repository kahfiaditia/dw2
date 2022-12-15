<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateAtToUksKeperawatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uks_perawatan', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dropColumn('masuk');
            $table->dropColumn('keluar');
        });

        Schema::table('uks_perawatan', function (Blueprint $table) {
            $table->time('masuk')->nullable()->after('tgl');
            $table->time('keluar')->nullable()->after('masuk');
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
            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
            $table->dropColumn('masuk');
            $table->dropColumn('keluar');
        });

        Schema::table('uks_perawatan', function (Blueprint $table) {
            $table->time('masuk')->nullable()->after('tgl');
            $table->time('keluar')->nullable()->after('masuk');
        });
    }
}
