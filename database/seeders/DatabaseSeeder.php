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
            // 'sensor_id' => "SEN-F-00001",
            'sensor_name' => "Unnamed Sensor",
            'is_activated' => false,
            'activation_password' => "9218cbVmX2#",
        ]);
    }
}
