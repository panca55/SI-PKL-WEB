<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Mayor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil user_id dan department_id yang ada
        $userIds = User::where('role', 'SISWA')->pluck('id')->toArray();
        $departments = Mayor::all();

        // Jurusan yang ada di SMKN 2 Padang
        // $jurusan = [
        //     'TKJ' => 'Teknik Komputer dan Jaringan',
        //     'RPL' => 'Rekayasa Perangkat Lunak',
        //     'UPW' => 'Usaha Perjalanan Wisata',
        //     'OTKP' => 'Otomasi dan Tata Kelola Perkantoran',
        //     'AKL' => 'Akuntansi dan Keuangan Lembaga',
        //     'BDP' => 'Bisnis Daringan dan Pemasaran'
        // ];

        foreach ($userIds as $userId) {
            $department = $departments->random();
            $tahunLahir = $faker->numberBetween(2007, 2010);
            $tanggalLahir = $faker->dateTimeBetween("$tahunLahir-01-01", "$tahunLahir-12-31")->format('Y-m-d');

            Student::create([
                'user_id' => $userId,
                'mayor_id' => $department->id,
                'nisn' => $faker->unique()->numberBetween(1000000000, 9999999999),
                'nama' => $faker->name,
                'tahun_masuk' => $faker->numberBetween(2020, 2023),
                'jenis_kelamin' => $faker->randomElement(['PRIA', 'WANITA']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $tanggalLahir,
                'alamat_siswa' => $faker->address,
                'alamat_ortu' => $faker->address,
                'hp_siswa' => $faker->unique()->numerify('08##########'),
                'hp_ortu' => $faker->unique()->numerify('08##########'),
                'foto' => null
            ]);
        }
    }
}
