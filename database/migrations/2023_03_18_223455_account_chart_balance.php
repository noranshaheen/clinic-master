<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounting_chart_balance', function (Blueprint $table) {
            $table->foreignId('accounting_chart_id');
            $table->decimal('credit', 15, 3);
            $table->decimal('debit', 15, 3);
            $table->date('balance_date');
            $table->boolean('transferable');
            $table->timestamps();
            $table->index(['accounting_chart_id', 'balance_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_chart_balance');
    }
};
