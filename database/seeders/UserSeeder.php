<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['SISWA', 'GURU', 'INSTRUKTUR', 'PERUSAHAAN'];
        $faker = Faker::create('id_ID'); // Locale Indonesia

        foreach ($roles as $role) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('users')->insert([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'), // Password default untuk testing
                    'role' => $role,
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
