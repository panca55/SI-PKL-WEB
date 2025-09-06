<?php

namespace App\Exports;

use App\Models\Internship;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternshipExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Internship::with(['student', 'teacher', 'corporation'])
            ->get()
            ->map(function ($internship) {
                return [
                    'NISN' => $internship->student->nisn,
                    'Jurusan' => $internship->student->mayor->department->nama,
                    'Kelas' => $internship->student->mayor->nama,
                    'Nama Siswa' => $internship->student->nama,
                    'Konsentrasi Siswa' => $internship->student->konsentrasi,
                    'Tahun Masuk Siswa' => $internship->student->tahun_masuk,
                    'Jenis Kelamnin Siswa' => $internship->student->jenis_kelamin,
                    'Tempat/Tanggal Lahir Siswa' => $internship->student->tempat_lahir,
                    'Tanggal Lahir Siswa' => $internship->student->tanggal_lahir,
                    'Alamat Ortu Siswa' => $internship->student->alamat_ortu,
                    'No Hp Ortu Siswa' => $internship->student->hp_ortu,
                    'Alamat Siswa' => $internship->student->alamat_siswa,
                    'No HP Siswa' => $internship->student->hp_siswa,
                    'Nama Guru Pembimbing' => $internship->teacher->nama,
                    'Nama Perusahaan' => $internship->corporation->nama,
                    'Tahun Ajaran' => $internship->tahun_ajaran,
                    'Tanggal Mulai' => Carbon::parse($internship->tanggal_mulai)->format('d M Y'),
                    'Tanggal Berakhir' => Carbon::parse($internship->tanggal_berakhir)->format('d M Y'),
                ];
            });
    }
    public function headings(): array
    {
        return [
            'NISN',
            'Jurusan',
            'Kelas',
            'Nama Siswa',
            'Konsentrasi Siswa',
            'Tahun Masuk Siswa',
            'Jenis Kelamnin Siswa',
            'Tempat Lahir Siswa',
            'Tanggal Lahir Siswa',
            'Alamat Ortu Siswa',
            'No Hp Ortu Siswa',
            'Alamat Siswa',
            'No HP Siswa',
            'Nama Guru Pembimbing',
            'Nama Perusahaan',
            'Tahun Ajaran',
            'Tanggal Mulai',
            'Tanggal Berakhir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text with a larger font size
            1    => ['font' => ['bold' => true, 'size' => 14]],

            // Add borders to all cells
            'A1:I' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],

            // Align the header row center
            'A1:I1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
