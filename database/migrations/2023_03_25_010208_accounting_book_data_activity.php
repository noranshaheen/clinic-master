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
        Schema::create('accounting_book_data_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_book_data_id');
            $table->foreignId('accounting_activity_id');
            $table->decimal('contribution_percentage', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_book_data_activity');
    }
};