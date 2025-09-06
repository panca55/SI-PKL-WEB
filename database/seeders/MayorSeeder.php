<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Mayor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MayorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all departments
        $departments = Department::all();

        foreach ($departments as $department) {
            // Generate 6 classes for each department
            for ($i = 1; $i <= 6; $i++) {
                $shortenedName = $this->shortenDepartmentName($department->nama, $i);

                // Insert a new record into the mayors table
                Mayor::create([
                    'department_id' => $department->id,
                    'nama' => $shortenedName
                ]);
            }
        }
    }

    private function shortenDepartmentName($nama, $classNumber)
    {
        // Convert the name to uppercase to handle case-insensitivity
        $nama = strtoupper($nama);

        // Define common department name patterns and their abbreviations
        $abbreviations = [
            'TEKNIK KOMPUTER DAN JARINGAN' => 'TKJ',
            'REKAYASA PERANGKAT LUNAK' => 'RPL',
            'USAHA PERJALANAN WISATA' => 'UPW',
            'OTOMASI DAN TATA KELOLA PERKANTORAN' => 'OTKP',
            'AKUNTANSI DAN KEUANGAN LEMBAGA' => 'AKL',
            'BISNIS DARINGAN DAN PEMASARAN' => 'BDP',

        ];

        // Check if the department name matches one of the known patterns
        foreach ($abbreviations as $pattern => $abbreviation) {
            if (strpos($nama, $pattern) !== false) {
                return 'XII ' . $abbreviation . ' ' . $classNumber;
            }
        }

        // Default behavior: use the first three letters as an abbreviation
        return 'XII ' . substr($nama, 0, 3) . ' ' . $classNumber;
    }
}
