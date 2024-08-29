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
        Schema::create('preferred_sub_classifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_id');
            $table->foreign('classification_id')->references('id')->on('preferred_classifications')->onDelete('cascade');
            $table->string('sub_classification');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferred_sub_classifications');
    }
};