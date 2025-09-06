<?php

namespace App\Http\Controllers\Corporation;

use Carbon\CarbonPeriod;
use App\Models\Internship;
use App\Models\Corporation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['student', 'instructor'])
            ->where('corporation_id', $corporation->id)
            ->where('status', 'TIDAK AKTIF')
            ->get();
        if(request()->wantsJson()){
            return response()->json(['siswa'=>$internships]);
        }
        return view('pages.corporation.siswa.index', compact('internships'));
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
        if(request()->wantsJson()){
            return response()->json(['data'=>[
                'internship'=>$internship,
                'absents'=>$absents,
                'logbooks'=>$logbooks,
                'summary'=>$summary,
                ]]);
        }

        return view('pages.corporation.siswa.show', compact(
            'internship',
            'absents',
            'logbooks',
            'summary'
        ));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
