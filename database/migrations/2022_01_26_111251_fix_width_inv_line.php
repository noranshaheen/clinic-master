<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixWidthInvLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::unprepared("alter table InvoiceLine change salesTotal salesTotal  decimal(11,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change total total  decimal(11,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change valueDifference valueDifference  decimal(11,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change totalTaxableFees totalTaxableFees  decimal(11,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change netTotal netTotal  decimal(11,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change itemsDiscount itemsDiscount  decimal(11,3) NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::unprepared("alter table InvoiceLine change salesTotal salesTotal  decimal(9,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change total total  decimal(9,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change valueDifference valueDifference  decimal(9,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change totalTaxableFees totalTaxableFees  decimal(9,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change netTotal netTotal  decimal(9,3) NOT NULL;");
		DB::unprepared("alter table InvoiceLine change itemsDiscount itemsDiscount  decimal(9,3) NOT NULL;");
        //
    }
}
