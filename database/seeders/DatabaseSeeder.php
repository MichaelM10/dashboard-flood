<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => "Test User",
            'email' => "user@user.com",
            'password' => bcrypt("testuser123"),
        ]);

        DB::table('sensors')->insert([
            'sensor_name' => "Unnamed Sensor",
            'type' => "F",
            'visibility' => "Not set",
            'is_activated' => false,
            'access_password' => "k10AX#bZ!",
            'activation_password' => "9218cbVmX2#",
        ]);

        DB::table('sensor_fields')->insert([
            'sensor_id' => "1",
            'field_name' => "Water Level",
            'field_type' => "String",
        ]);
    }
}
