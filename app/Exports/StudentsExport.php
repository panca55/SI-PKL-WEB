<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }
    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'nisn' => $student->nisn,
                'nama' => $student->nama,
                'kelas' => $student->mayor->nama,
                'konsentrasi' => $student->konsentrasi,
                'tahun_masuk' => $student->tahun_masuk,
                'jenis_kelamin' => $student->jenis_kelamin,
                'status_pkl' => $student->status_pkl,
                'tempat_lahir' => $student->tempat_lahir,
                'tanggal_lahir' => $student->tanggal_lahir,
                'alamat_siswa' => $student->alamat_siswa,
                'alamat_ortu' => $student->alamat_ortu,
                'hp_siswa' => $student->hp_siswa,
                'hp_ortu' => $student->hp_ortu,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Lengkap',
            'Kelas',
            'Konsentrasi',
            'Tahun Masuk',
            'Jenis Kelamin',
            'Status PKL',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat Siswa',
            'Alamat Ortu',
            'No HP Siswa',
            'No HP Ortu'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text with a larger font size
            1    => ['font' => ['bold' => true, 'size' => 14]],

            // Add borders to all cells
            'A1:M' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],

            // Align the header row center
            'A1:M1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
