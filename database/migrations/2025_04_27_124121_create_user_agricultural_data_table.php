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
        Schema::create('user_agricultural_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('farm_name')->nullable();
            $table->float('farm_size')->nullable();
            $table->string('farm_size_unit')->default('acres');
            $table->string('location')->nullable();
            $table->string('climate_zone')->nullable();
            $table->string('soil_type')->nullable();
            $table->json('current_crops')->nullable();
            $table->json('farming_methods')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_agricultural_data');
    }
};
