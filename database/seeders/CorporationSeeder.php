<?php

namespace Database\Seeders;

use App\Models\Corporation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil user_id dengan role PERUSAHAAN
        $userIds = User::where('role', 'PERUSAHAAN')->pluck('id')->toArray();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($userIds as $userId) {
            $deskripsi = collect(range(1, 5))->map(fn () => $faker->text(200))->implode(' ');
            $mulai_hari_kerja = $faker->randomElement($days);
            $akhir_hari_kerja = $faker->randomElement($days);
            Corporation::create([
                'user_id' => $userId,
                'nama' => $faker->company,
                'alamat' => $faker->address,
                'quota' => $faker->numberBetween(1, 10),
                'jam_mulai' => $faker->time('H:i', '07:00'),
                'jam_berakhir' => $faker->time('H:i', '17:00'),
                'hp' => $faker->unique()->numerify('08##########'),
                'foto' => null,
                'deskripsi' => $deskripsi,
                'mulai_hari_kerja' => $mulai_hari_kerja,
                'akhir_hari_kerja' => $akhir_hari_kerja,
            ]);
        }
    }
}
