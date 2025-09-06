<?php

namespace App\Console\Commands;

use App\Models\Absent;
use App\Models\Internship;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoAbsentCommand extends Command
{
    protected $signature = 'auto:absent';
    protected $description = 'Menandai siswa yang belum absen sebagai ALPHA pada pukul 23:59 dari Senin sampai Sabtu';

    public function handle()
    {
        // Set lokalisasi ke Indonesia
        Carbon::setLocale('id');

        $now = Carbon::now('Asia/Jakarta');

        // Cek apakah sekarang pukul 23:59 dan hari Senin sampai Sabtu
        if ($now->format('H:i') === '22:14' && in_array($now->dayName, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])) {
            $today = $now->format('Y-m-d');

            $internships = Internship::where('status', 'AKTIF')->get();

            foreach ($internships as $internship) {
                $absent = Absent::firstOrCreate(
                    [
                        'internship_id' => $internship->id,
                        'tanggal' => $today,
                    ],
                    [
                        'keterangan' => 'ALPHA',
                    ]
                );

                if ($absent->wasRecentlyCreated) {
                    $this->info("Absensi otomatis diisi sebagai ALPHA untuk siswa ID: " . $internship->student_id);
                } else {
                    $this->info("Absensi sudah ada untuk siswa ID: " . $internship->student_id);
                }
            }
        } else {
            $this->info("Bukan waktu untuk mengecek absensi.");
        }

        return 0;
    }
}
