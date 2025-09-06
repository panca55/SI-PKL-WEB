<?php

namespace App\Http\Controllers\Corporation;

use Carbon\Carbon;
use App\Models\Student;
use Carbon\CarbonPeriod;
use App\Models\Instructor;
use App\Models\Internship;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $corporation = Corporation::where('user_id', $user->id)->first();
        if (!$corporation) {
            return redirect()->route('corporation/profile.create')->with('message', 'Silakan lengkapi data diri Anda.');
        }
        $internships = Internship::with(['student.mayor.department', 'instructor'])
            ->where('corporation_id', $corporation->id)
            ->where('status', 'AKTIF')
            ->get();
        // dd($internships);
        $instructors = Instructor::where('corporation_id', $corporation->id)
            ->withCount(['internship as students_count' => function ($query) {
                $query->whereNotNull('student_id');
            }])
            ->get();
        if (request()->wantsJson()) {
            return response()->json([
                'corporation' => $corporation,
                'internships' => $internships,
                'instructors' => $instructors,
                'message' => 'Data Siswa PKL berhasil diambil'
            ], 200);
        }
        // dd($instructors);
        return view('pages.corporation.dashboard', compact('internships', 'instructors'));
    }

    public function assignInstructor(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'student_id' => 'required|exists:internships,id', // Menggunakan tabel internships untuk validasi student_id
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $user = Auth::user();
        // Mencari data internship berdasarkan dari user yang login
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();

        $internship = Internship::where('corporation_id', $corporation->id)
            ->where('id', $validatedData['student_id'])
            ->firstOrFail();

        // Menetapkan instructor_id ke internship
        $internship->instructor_id = $validatedData['instructor_id'];
        $internship->save();
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Instruktur berhasil ditugaskan ke siswa.',
                'data' => [
                    'internship_id' => $internship->id,
                    'instructor_id' => $internship->instructor_id,
                ],
            ], 200);
        }

        return redirect()->route('corporation/dashboard.index')->with('success', 'Instruktur berhasil ditugaskan ke siswa.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $internship = Internship::with([
            'student' => function ($query) {
                $query->with('instructor');
            },
            'logbook'
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

        return view('pages.corporation.detail.show', compact(
            'internship',
            'absents',
            'logbooks',
            'summary'
        ));
    }

    private function calculateAttendanceSummary($internshipId)
    {
        // Mengambil data absensi berdasarkan internship_id
        $absences = Internship::findOrFail($internshipId)->absent;

        // Inisialisasi variabel untuk menghitung kehadiran
        $summary = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'percentage' => 0,
        ];

        $totalDays = $absences->count();

        // Loop melalui absensi dan hitung jumlah tiap status
        foreach ($absences as $absence) {
            if ($absence->status === 'HADIR') {
                $summary['hadir']++;
            } elseif ($absence->status === 'IZIN') {
                $summary['izin']++;
            } elseif ($absence->status === 'SAKIT') {
                $summary['sakit']++;
            } elseif ($absence->status === 'ALPHA') {
                $summary['alpha']++;
            }
        }

        // Hitung persentase kehadiran
        if ($totalDays > 0) {
            $summary['percentage'] = round(($summary['hadir'] / $totalDays) * 100, 2);
        }

        return $summary;
    }

    public function updateInstructor(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $internship = Internship::findOrFail($request->internship_id);
        $internship->instructor_id = $request->instructor_id;
        $internship->save();

        return redirect()->route('corporation.dashboard')->with('success', 'Instruktur berhasil diperbarui.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $internship = Internship::findOrFail($request->internship_id);
        $internship->instructor_id = $request->instructor_id;
        $internship->save();

        return redirect()->route('corporation/dashboard.index')->with('success', 'Instruktur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
