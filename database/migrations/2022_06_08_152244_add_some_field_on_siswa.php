<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldOnSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string("rt", 2)->after('tempat_tinggal');
            $table->string('rw', 2)->after('rt');
            $table->string('dusun', 100)->after('rw');
            $table->string('village')->after('dusun');
            $table->string('district')->after('village');
            $table->string('postal_code', 5)->after('district');
            $table->string('transportation')->after('postal_code');
            $table->string('child_order', 2)->after('transportation');
            $table->string('is_have_kip', 10)->after('child_order');
            $table->string('is_receive_kip', 10)->after('is_have_kip');
            $table->string('reason_reject_kip')->nullable()->after('is_receive_kip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('rt');
            $table->dropColumn('rw');
            $table->dropColumn('dusun');
            $table->dropColumn('village');
            $table->dropColumn('district');
            $table->dropColumn('postal_code');
            $table->dropColumn('transportation');
            $table->dropColumn('child_order');
            $table->dropColumn('is_have_kip');
            $table->dropColumn('is_receive_kip');
            $table->dropColumn('reason_reject_kip');
        });
    }
}
