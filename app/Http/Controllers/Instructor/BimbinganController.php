<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Note;
use App\Models\Logbook;
use App\Models\Teacher;
use Carbon\CarbonPeriod;
use App\Models\Instructor;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $instructor = Instructor::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['student.mayor.department', 'corporation', 'teacher'])
            ->where('instructor_id', $instructor->id)
            ->where('status', 'AKTIF')
            ->with(['absents' => function ($query) use ($today) {
                $query->whereDate('created_at', $today);
            }])
            ->get();
        if(request()->wantsJson()){
            return response()->json([
                'internship'=>$internships,
                ]);
        }
        return view('pages.instructor.bimbingan.index', compact(
            'internships',
        ));
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
        $request->validate([
            'logbook_id' => 'required|exists:logbooks,id',
            'note_type' => 'required|in:GURU,INSTRUKTUR',
            'catatan' => 'required|string',
            'penilaian' => 'required|in:SUDAH BAGUS,PERBAIKI',
        ]);

        // Create a new note
        Note::create([
            'logbook_id' => $request->logbook_id,
            'note_type' => $request->note_type,
            'catatan' => $request->catatan,
            'penilaian' => $request->penilaian,
        ]);
        if($request->wantsJson()){
            return response()->json(['message' =>'Komentar berhasil ditambahkan']);
        }

        // Redirect back with success message
        return redirect()->route('instructor/detailLogbook', $request->logbook_id)->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        $absents = $internship->absents()->orderBy('tanggal', 'desc')->paginate(5); // 5 data per halaman
        $logbooks = $internship->logbook()->orderBy('tanggal', 'desc')->paginate(5); // 5 data per halaman

        $startDate = Carbon::parse($internship->tanggal_mulai);
        $endDate = Carbon::parse($internship->tanggal_berakhir);
        $period = CarbonPeriod::create($startDate, $endDate);

        // Assuming company works Monday to Friday
        $workDays = $period->filter('isWeekday')->count();
        // Hitung total persentase kehadiran siswa
        $presentDays = $internship->absents->where('keterangan', 'HADIR')->count();
        $attendancePercentage = ($presentDays / $workDays) * 100;
        // dd($internship);
        if(request()->wantsJson()){
            $internship->student;
            $internship->corporation;
            $internship->instructor;
            $internship->logbook;
            return response()->json([
                'internship'=>$internship,
                'attendancePercentage' => $attendancePercentage,
                ]);
        }
        return view('pages.instructor.bimbingan.show', compact(
            'internship',
            'absents',
            'logbooks',
            'attendancePercentage'
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
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $request->validate([
            'catatan' => 'required|string',
            'penilaian' => 'required|in:SUDAH BAGUS,PERBAIKI',
        ]);

        $note->update([
            'catatan' => $request->catatan,
            'penilaian' => $request->penilaian,
        ]);
        if($request->wantsJson()){
            return response()->json(['message' =>'Komentar berhasil diperbarui']);
        }
        return redirect()->route('instructor/detailLogbook', $note->logbook_id)->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function detailLogbook($id)
    {
        $logbook = Logbook::with('note')
            ->findOrFail($id);
        $noteGuru = Note::where('logbook_id', $logbook->id)->where('note_type', 'GURU')->first();
        $noteInstruktur = Note::where('logbook_id', $logbook->id)->where('note_type', 'INSTRUKTUR')->first();
        $grades = Note::GRADE;
        if(request()->wantsJson()){
            
            return response()->json([
                'logbook'=>$logbook,
                'noteGuru' => [
                    'catatan' => $noteGuru->catatan ?? 'Belum diisi',
                    'penilaian' => $noteGuru->penilaian ?? 'Belum diisi',
                ],
                'noteInstruktur' => [
                    'catatan' => $noteInstruktur->catatan ?? 'Belum diisi',
                    'penilaian' =>
                    $noteInstruktur->penilaian ?? 'Belum diisi'
                ],
                'grades'=>$grades,
                ]);
        }
        return view('pages.instructor.bimbingan.detail', compact(
            'logbook',
            'noteGuru',
            'noteInstruktur',
            'grades',
        ));
    }
}
