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
            $table->string('additionalInformation',4000)->nullable();
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
            $table->foreignId('appointment_id');
            $table->foreignId('clinic_id');
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
            $table->string('dose')->nullable();
            $table->string('service_fees',2000)->nullable();
            $table->timestamps();
        });

        Schema::create('doses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('detection_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->timestamps();
        });

        Schema::create('patient_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->foreignId('appointment_id');
            $table->foreignId('doctor_id');
            $table->integer('detection_fees');
            $table->integer('service_fees')->nullable();
            $table->timestamps();
        });

        Schema::create('durations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->tinyInteger('storable')->nullable();
            // $table->float('selling_price')->nullable();
            // $table->float('purches_price')->nullable();
            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->foreignId('clinic_id')->constrained('clinics');
            $table->timestamps();
        });

        Schema::create('inv_stock', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('inventory_id')->constrained('inventories');
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_stock_id')->constrained('inv_stock');
            $table->foreignId('item_id')->constrained('items');
            $table->date('date');
            $table->enum('type',['in','out']);
            $table->integer('quantity');
            $table->float('unit_price')->nullable();
            $table->float('total_price')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_total_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_stock_id')->constrained('inv_stock');
            $table->foreignId('item_id')->constrained('items');
            $table->integer('quantity_in_hand');
            $table->timestamps();
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['administrative','purchase']);
            $table->foreignId('doctor_id')->nullable();
            $table->foreignId('clinic_id')->constrained('clinics');
            $table->date('date');
            $table->string('totalAmount');
            $table->timestamps();
        });
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->float('price')->nullable();
            $table->float('quantity')->nullable();
            $table->string('total');
            $table->date('date');
            $table->foreignId('bill_id')->constrained('bills');
            $table->timestamps();
        });
        Schema::create('spendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreignId('clinic_id');
            $table->foreignId('item_id');
            $table->float('quantity');
            $table->foreignId('patient_id');
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
