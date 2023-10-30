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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->references('id')->on('appointments');
            $table->foreignId('patient_id')->references('id')->on('patients');
            $table->foreignId('doctor_id')->references('id')->on('doctors');
            $table->string('paid_amount');
            $table->foreignId('receiver_team_id')->nullable();
            $table->foreignId('receiver_id')->nullable();
            $table->date('date');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_payments');
    }
};
