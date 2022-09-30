<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoiceIdDiskon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('diskon_id')->nullable()->after('class_id');
            $table->foreign('diskon_id')->references('id')->on('diskon');
            $table->double('amount_diskon_pembayaran')->nullable()->after('diskon_id');
            $table->double('amount_diskon_prestasi')->nullable()->after('amount_diskon_pembayaran');
            $table->dateTime('date_transaksi')->after('amount_diskon_prestasi');
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
            $table->dropForeign(['diskon_id']);
            $table->dropColumn('diskon_id');
            $table->dropColumn('amount_diskon_pembayaran');
            $table->dropColumn('amount_diskon_prestasi');
            $table->dropColumn('date_transaksi');
        });
    }
}
