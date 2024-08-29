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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_additional')->nullable();
            $table->string('iso2')->nullable();
            $table->string('dialcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();           
            $table->string('zipcode')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('classification_id')->nullable();
            $table->foreign('classification_id')->references('id')->on('preferred_classifications')->onDelete('cascade');
            $table->unsignedBigInteger('sub_classification_id')->nullable();
            $table->foreign('sub_classification_id')->references('id')->on('preferred_sub_classifications')->onDelete('cascade');
            $table->text('external_link')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('job_skill')->nullable();           
            $table->longText('description')->nullable();       
            $table->string('profile_visibility')->default('Show Profile');                           
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
