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
        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('another_phone')->nullable();
            $table->foreignId('specialty_id');
            $table->string('title')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('phone');
            $table->string('type');
            $table->date('date_of_birth')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('insurance_company')->nullable();
            $table->timestamps();
        });

        Schema::create('reseptionists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });

        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('clinic_id');
            $table->timestamps();
        });

        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('specialty_id');
            $table->timestamps();
        });

        Schema::create('analysis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('specialty_id');
            $table->timestamps();
        });

        Schema::create('rays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('specialty_id')->nullable();
            $table->timestamps();
        });

        Schema::create('diagnosis_drug', function (Blueprint $table) {
            $table->foreignId('diagnosis_id');
            $table->foreignId('drug_id');
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->foreignId('doctor_id');
            $table->foreignId('clinic_id');
            $table->foreignId('room_id')->nullable();
            $table->foreignId('patient_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default("hold");
            $table->string('amount',2000)->nullable();
            $table->string('notes', 4000)->nullable();
            $table->integer('done')->nullable();
            $table->integer('cancelled')->nullable();
            $table->timestamps();
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreignId('patient_id');
            $table->string('diagnosis', 4000)->nullable();
            $table->string('analysis', 4000)->nullable();
            $table->string('rays', 4000)->nullable();
            $table->string('notes', 4000)->nullable();
            $table->dateTime('dateTimeIssued');
            $table->timestamps();
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id');
            $table->foreignId('drug_id');
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('doses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('durations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('clinics');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('specialities');
    }
};
