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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('another_phone')->nullable();
            $table->string('specialty');
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
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->timestamps();
                    });

        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
                        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('status')->default("hold");
            $table->integer('done')->nullable();
            $table->integer('cancelled')->nullable();
            $table->timestamps();
                        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->string('diagnosis',4000);
            $table->string('analysis',4000);
            $table->string('rays',4000);
            $table->string('notes',4000);
            $table->dateTime('dateTimeIssued');
            $table->timestamps();
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
                            });
                    
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('drug_id');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
                            });

        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
