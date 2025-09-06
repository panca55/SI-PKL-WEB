<?php

namespace App\Exports;

use App\Models\Evaluation;
use App\Models\Internship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvaluationsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Evaluation::with(['internship'])
            ->get()
            ->map(function ($evaluation) {
                return [
                    'NISN' => $evaluation->internship->student->nisn,
                    'Nama Siswa' => $evaluation->internship->student->nama,
                    'Kelas' => $evaluation->internship->student->mayor->nama,
                    'Nama Guru Pembimbing' => $evaluation->internship->teacher->nama,
                    'Nama Perusahaan' => $evaluation->internship->corporation->nama,
                    'Rata Rata Nilai Monitoring' => $evaluation->monitoring,
                    'Rata Rata Nilai Sertifikat' => $evaluation->sertifikat,
                    'Nilai Jurnal' => $evaluation->logbook,
                    'Nilai Presentasi' => $evaluation->presentasi,
                    'Nilai Akhir' => $evaluation->nilai_akhir,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Siswa',
            'Kelas',
            'Nama Guru Pembimbing',
            'Nama Perusahaan',
            'Rata Rata Nilai Monitoring',
            'Rata Rata Nilai Sertifikat',
            'Nilai Jurnal',
            'Nilai Presentasi',
            'Nilai Akhir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text with a larger font size
            1    => ['font' => ['bold' => true, 'size' => 14]],

            // Add borders to all cells
            'A1:J' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],

            // Align the header row center
            'A1:J1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
