<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Internship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AbsensiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
        $internships = Internship::with(['student', 'absents'])->get();

        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();

        return $internships->map(function ($internship) use ($daysInMonth, $startDate, $endDate) {
            $data = [
                'NISN' => $internship->student->nisn,
                'Nama' => $internship->student->nama,
            ];

            // Filter absents for current month
            $monthlyAbsents = $internship->absents->whereBetween('tanggal', [$startDate, $endDate]);

            // Add daily attendance
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = Carbon::create($this->year, $this->month, $i)->format('Y-m-d');
                $absent = $monthlyAbsents->where('tanggal', $date)->first();
                $data[$i] = $absent ? substr($absent->keterangan, 0, 1) : '-';
            }

            // Add summary for current month only
            $data = array_merge($data, [
                'Hadir' => $monthlyAbsents->where('keterangan', 'HADIR')->count(),
                'Izin' => $monthlyAbsents->where('keterangan', 'IZIN')->count(),
                'Sakit' => $monthlyAbsents->where('keterangan', 'SAKIT')->count(),
                'Alpha' => $monthlyAbsents->where('keterangan', 'ALPHA')->count(),
                'Total' => $monthlyAbsents->count(),
            ]);

            return $data;
        });
    }

    public function headings(): array
    {
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
        $headers = ['NISN', 'Nama'];

        // Add dates
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $headers[] = $i;
        }

        // Add summary headers
        return array_merge($headers, ['Hadir', 'Izin', 'Sakit', 'Alpha', 'Total']);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;
                $monthName = Carbon::create($this->year, $this->month, 1)->format('F Y');

                // Calculate last column letter
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + $daysInMonth + 5); // +5 for summary columns
                $lastDateColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2 + $daysInMonth);
                $totalRows = $event->sheet->getHighestRow();

                // Insert and style month name
                $event->sheet->insertNewRowBefore(1, 1);
                $event->sheet->mergeCells('C1:' . $lastDateColumn . '1');
                $event->sheet->setCellValue('C1', strtoupper($monthName));

                // Style for month name
                $event->sheet->getStyle('C1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E2EFDA']
                    ]
                ]);

                // Style for headers (row 2)
                $event->sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000']
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '9BC2E6']
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                // Style for data cells
                $event->sheet->getStyle('A3:' . $lastColumn . $totalRows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ]
                ]);

                // Special alignment for Nama column
                $event->sheet->getStyle('B3:B' . $totalRows)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                    ]
                ]);

                // Style for summary columns
                $summaryColumns = ['Hadir', 'Izin', 'Sakit', 'Alpha', 'Total'];
                $startSummaryCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(3 + $daysInMonth);

                foreach ($summaryColumns as $index => $column) {
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(3 + $daysInMonth + $index);
                    $event->sheet->getStyle($colLetter . '2:' . $colLetter . $totalRows)->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'E2EFDA']
                        ]
                    ]);
                }

                // Set column width for NISN and Nama
                $event->sheet->getColumnDimension('A')->setWidth(15);
                $event->sheet->getColumnDimension('B')->setWidth(25);

                // Freeze panes (lock headers)
                $event->sheet->freezePane('C3');
            }
        ];
    }
}
