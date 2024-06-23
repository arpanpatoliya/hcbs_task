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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('slot_id');
            $table->uuid('clinician_id');
            $table->string('appointment_no');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('signature');
            $table->enum('appointment_status',['Confirmed','Cancelled','Completed','Pending'])->default('Pending');
            $table->text('fcm_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
