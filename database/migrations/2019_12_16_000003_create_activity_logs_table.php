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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();            
            $table->string('type')->nullable();
            $table->enum('sender', ['Customer', 'Superadmin', 'Admin'])->default('Admin');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullbale();
            $table->string('model')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
