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
        Schema::create('electrician_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('experience');
            $table->string('skill');
            $table->string('service_area');
            $table->string('hourly_rate');
            $table->string('contact_number');
            $table->string('electrician_image');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electrician_profiles');
    }
};
