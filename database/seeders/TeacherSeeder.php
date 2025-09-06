<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil user_id dengan role GURU
        $userIds = User::where('role', 'GURU')->pluck('id')->toArray();

        $golonganPNS = [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];

        $bidangStudi = [
            'TKJ' => 'Teknik Komputer dan Jaringan',
            'RPL' => 'Rekayasa Perangkat Lunak',
            'UPW' => 'Usaha Perjalanan Wisata',
            'OTKP' => 'Otomasi dan Tata Kelola Perkantoran',
            'AKL' => 'Akuntansi dan Keuangan Lembaga',
            'BDP' => 'Bisnis Daringan dan Pemasaran'
        ];

        foreach ($userIds as $userId) {
            $bidangStudiKey = array_rand($bidangStudi);

            Teacher::create([
                'user_id' => $userId,
                'nip' => $faker->unique()->numerify('###############'),
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['PRIA', 'WANITA']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date(),
                'alamat' => $faker->address,
                'hp' => $faker->unique()->numerify('08##########'),
                'golongan' => $faker->randomElement($golonganPNS),
                'bidang_studi' => $bidangStudiKey,
                'pendidikan_terakhir' => $faker->randomElement(['S1', 'S2', 'S3']),
                'jabatan' => $faker->randomElement(['Guru']),
                'foto' => null
            ]);
        }
    }
}
