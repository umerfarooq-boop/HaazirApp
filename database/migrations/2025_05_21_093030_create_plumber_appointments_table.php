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
        Schema::create('plumber_appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('plumber_p_id');
            $table->string('p_problem_image');
            $table->string('description');
            $table->string('status')->default('disabled');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plumber_appointments');
    }
};
