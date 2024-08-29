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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->foreign('employer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->unsignedBigInteger('sub_zone_id')->nullable();
            $table->foreign('sub_zone_id')->references('id')->on('sub_zones')->onDelete('cascade');
            $table->string('position_name');
            $table->unsignedBigInteger('classification_id')->nullable();
            $table->foreign('classification_id')->references('id')->on('preferred_classifications')->onDelete('cascade');
            $table->unsignedBigInteger('sub_classification_id')->nullable();
            $table->foreign('sub_classification_id')->references('id')->on('preferred_sub_classifications')->onDelete('cascade');
            $table->text('location')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->integer('no_of_position')->default(1);
            $table->string('position_type')->nullable();
            $table->string('contract_days')->nullable();
            $table->string('shift_type')->nullable();
            $table->string('career_level')->nullable();
            $table->string('gender')->nullable();
            $table->string('salary_type')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('education')->nullable();
            $table->longText('skills_required')->nullable();
            $table->longText('working_days')->nullable();
            $table->string('working_start_hour')->nullable();
            $table->string('working_end_hour')->nullable();
            $table->unsignedBigInteger('salary_from')->default(0);
            $table->unsignedBigInteger('salary_upto')->default(0);
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->boolean('open')->default(false);
            $table->boolean('hide_salary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
