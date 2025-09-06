<?php

namespace App\Http\Controllers\Student;

use App\Models\Note;
use App\Models\Logbook;
use App\Models\Student;
use App\Models\Internship;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Mencari data internship berdasarkan student_id dari user yang login
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->first();

        if (!$internship) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Masa PKL belum dimulai'], 404);
            }
            return redirect()->route('student/dashboard')->with('message', 'Masa PKL belum dimulai.');
        }

        $logbooks = Logbook::where('internship_id', $internship->id)->get();

        if ($logbooks->isEmpty()) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Logbook belum ada'], 404);
            }
            return redirect()->route('student/dashboard')->with('message', 'Logbook belum ada.');
        }

        if (request()->wantsJson()) {
            return response()->json(['logbooks' => $logbooks], 200);
        }

        return view('pages.student.logbook.index', compact('logbooks'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $logbook = Logbook::with('note')->findOrFail($id);

        // Menggunakan eager loading untuk lebih efisien
        $noteGuru = $logbook->note->where('note_type', 'GURU')->first();
        $noteInstruktur = $logbook->note->where('note_type', 'INSTRUKTUR')->first();

        if (request()->wantsJson()) {
            return response()->json([
                'logbook' => $logbook,
                'note_guru' => $noteGuru,
                'note_instruktur' => $noteInstruktur,
            ], 200);
        }

        return view('pages.student.logbook.show', compact(
            'logbook',
            'noteGuru',
            'noteInstruktur'
        ));
    }

    /**
     * Print logbook as a PDF file.
     */
    public function print($id)
    {
        $logbook = Logbook::with('internship', 'note')->findOrFail($id);
        $noteInstruktur = $logbook->note->where('note_type', 'INSTRUKTUR')->first();
        $studentName = $logbook->internship->student->nama;
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName);
        $pdf = PDF::loadView('pages.student.logbook.print', compact('logbook', 'noteInstruktur'))
            ->setPaper('a4', 'portrait');

        $fileName = 'Jurnal_Harian_' . $studentName . '.pdf';
        if (request()->wantsJson()) {
            return response()->json([
                'pdf' => $logbook,
            ], 200);
        }
        return $pdf->stream($fileName);
    }

    // Placeholder methods, bisa diisi jika ada kebutuhan.
    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
