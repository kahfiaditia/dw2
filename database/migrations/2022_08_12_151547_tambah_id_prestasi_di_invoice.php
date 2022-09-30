<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahIdPrestasiDiInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('prestasi_id')->nullable()->after('amount_diskon_pembayaran');
            $table->foreign('prestasi_id')->references('id')->on('diskon_prestasi');
            $table->unsignedBigInteger('invoice_header_id')->nullable()->after('id');
            $table->foreign('invoice_header_id')->references('id')->on('invoice_header');
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
            $table->dropForeign(['prestasi_id']);
            $table->dropColumn('prestasi_id');
            $table->dropForeign(['invoice_header_id']);
            $table->dropColumn('invoice_header_id');
        });
    }
}
