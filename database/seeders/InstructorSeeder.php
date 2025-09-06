<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Corporation;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Get all user IDs where role is 'INSTRUKTUR'
        $userIds = User::where('role', 'INSTRUKTUR')->pluck('id')->toArray();

        // Fetch all corporations
        $corporations = Corporation::all();

        // Iterate over each corporation
        foreach ($corporations as $corporation) {
            // Pick a random user to be the instructor for this corporation
            $userId = array_shift($userIds);

            // If we run out of users, stop assigning instructors
            if (!$userId) {
                break;
            }

            // Insert a new instructor record for the corporation
            Instructor::create([
                'user_id' => $userId,
                'corporation_id' => $corporation->id,
                'nip' => $faker->unique()->numerify('###############'), // Generating a unique NIP
                'nama' => User::find($userId)->name, // Using the user's name
                'jenis_kelamin' => $faker->randomElement(['PRIA', 'WANITA']),
                'tempat_lahir' => $faker->city, // Example data
                'tanggal_lahir' => $faker->date($format = 'Y-m-d', $max = '2000-01-01'), // Random birth date
                'alamat' => $faker->address, // Example data
                'hp' => $faker->unique()->numerify('08##########'), // Random phone number
                'foto' => null, // Assuming you want this nullable
            ]);
        }
    }
}
