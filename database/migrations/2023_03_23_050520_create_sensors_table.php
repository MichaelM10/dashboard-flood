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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id('sensor_id');
            $table->string('sensor_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('visibility')->nullable();
            $table->string('access_password')->nullable();
            $table->double('gps_latitude')->nullable();
            $table->double('gps_longitude')->nullable();
            $table->double('sea_level')->nullable();
            $table->boolean('is_activated');
            $table->string('activation_password');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
