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
        Schema::create('sensor_fields', function (Blueprint $table) {
            $table->id('field_id');
            $table->foreignId('sensor_id')->references('sensor_id')->on('sensors');
            $table->string('field_name');
            $table->string('field_value')->nullable();
            $table->string('description')->nullable();
            // $table->integer('integer_value')->nullable;
            // $table->double('double_value')->nullable;
            // $table->string('string_value')->nullable;
            // $table->boolean('boolean_value')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_fields');
    }
};
