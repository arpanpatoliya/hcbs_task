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
        Schema::create('clinicians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('profile')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('gender',['Male','Female','Other']);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinicians');
    }
};
