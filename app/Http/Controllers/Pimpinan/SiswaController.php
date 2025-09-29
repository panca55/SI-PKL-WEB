<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function dashboard()
    {
        return view('pages.pimpinan.dashboard');
    }

    public function siswaPkl()
    {
        $internships = Internship::with('student', 'student.mayor.department', 'teacher', 'corporation', 'instructor')
            ->where('status', 'AKTIF')
            ->get();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $internships,'message' => 'Data Siswa PKL Berhasil Diambil', 'status' => 200
            ], status:200);
        }
        return view('pages.pimpinan.siswa-pkl.index', compact('internships'));
    }

    public function siswa()
    {
        return view('pages.pimpinan.siswa.index');
    }

    public function showSiswaPkl($id)
    {
        $internship = Internship::with([
            'student' => function ($query) {
                $query->with('instructor');
            },
            'student.mayor.department',
            'logbook',
            'evaluation',
            'certificate',
            'assessment'
        ])->findOrFail($id);

        $absents = $internship->absents()->orderBy('tanggal', 'desc')->paginate(5); // 5 data per halaman
        $logbooks = $internship->logbook()->orderBy('tanggal', 'desc')->paginate(5); // 5 data per halaman
        $startDate = Carbon::parse($internship->tanggal_mulai);
        $endDate = Carbon::parse($internship->tanggal_berakhir);
        $period = CarbonPeriod::create($startDate, $endDate);

        // Assuming company works Monday to Friday
        $workDays = $period->filter('isWeekday')->count();

        $summary = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'percentage' => 0,
        ];

        // $totalDays = $absents->count();s

        // Loop melalui absensi dan hitung jumlah tiap status
        foreach ($absents as $absence) {
            if ($absence->keterangan === 'HADIR') {
                $summary['hadir']++;
            } elseif ($absence->keterangan === 'IZIN') {
                $summary['izin']++;
            } elseif ($absence->status === 'SAKIT') {
                $summary['sakit']++;
            } elseif ($absence->keterangan === 'ALPHA') {
                $summary['alpha']++;
            }
        }

        // Hitung persentase kehadiran
        if ($workDays > 0) {
            $summary['percentage'] = round(($summary['hadir'] / $workDays) * 100);
        }
        if (request()->wantsJson()) {
            $email = $internship->student->user ? $internship->student->user->email : null;
            $internship->summary = $summary;
            $internship->student_email = $email;
            return response()->json($internship);
        }
        return view('pages.pimpinan.siswa-pkl.show', compact(
            'internship',
            'absents',
            'logbooks',
            'summary'
        ));
    }
}
