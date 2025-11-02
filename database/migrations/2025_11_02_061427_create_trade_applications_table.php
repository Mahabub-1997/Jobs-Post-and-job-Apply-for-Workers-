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
        Schema::create('trade_applications', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->foreignId('subscription_id')->nullable();

            // Applicant Details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name');
            $table->string('location');
            $table->string('phone');
            $table->string('email');
            $table->string('checkatrade_profile_link')->nullable();
            $table->string('trustatrader_profile_link')->nullable();


            $table->string('upload_trade_license')->nullable();
            $table->string('upload_business_insurance')->nullable();
            $table->string('passport_or_driving_license')->nullable();
            $table->string('certificate')->nullable();

            // Status field
            $table->enum('status', ['inactive', 'active'])->default('inactive');
            $table->enum('payment_status', ['pending', 'success'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_applications');
    }
};
