<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
        Schema::table('invoice', function (Blueprint $table) {
            $table->year('year_end')->nullable()->after('year');
            $table->string('month', 64)->nullable()->after('year_end');
            $table->unsignedBigInteger('payment_id')->nullable()->after('amount');
            $table->foreign('payment_id')->references('id')->on('payment');
            $table->unsignedBigInteger('class_id')->nullable()->after('siswa_id');
            $table->foreign('class_id')->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('year_end');
            $table->dropColumn('month');
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('month', 64)->nullable()->after('year');
            $table->unsignedBigInteger('class_id')->nullable()->after('siswa_id');
            $table->foreign('class_id')->references('id')->on('classes');
        });
    }
}
