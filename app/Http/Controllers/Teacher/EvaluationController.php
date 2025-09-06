<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Teacher;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Evaluation;
use App\Models\EvaluationDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['teacher', 'student.mayor.department', 'corporation', 'evaluation'])
            ->where('teacher_id', $teacher->id)
            ->where('status', 'AKTIF')
            ->get();
        // $currentDate = Carbon::now()->toDateString();
        $periode = EvaluationDate::first();
        $periodeData = null;
        if ($periode) {
            $periodeData = [
                'start_date' => Carbon::parse($periode->start_date)->format('d F Y'),
                'end_date' => Carbon::parse($periode->end_date)->format('d F Y'),
                'periode_text' => 'Periode Penilaian: ' . Carbon::parse($periode->start_date)->format('d F Y') . ' - ' . Carbon::parse($periode->end_date)->format('d F Y')
            ];
        }
        if(request()->wantsJson()){
            return response()->json([
                    'internship'=>$internships,
                    'periode'=>$periode,
            ]);
        }
        return view('pages.teacher.penilaian.index', compact('internships', 'periode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createEvaluation($id)
    {
        $internship = Internship::findOrFail($id);
        if(request()->wantsJson()){
            return response()->json([
                'evaluation'=>$internship,
            ]);
        }
        return view('pages.teacher.penilaian.create', compact('internship'));
    }

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
            'internship_id' => 'required|exists:internships,id',
            'monitoring' => 'required|numeric|min:0|max:100',
            'sertifikat' => 'required|numeric|min:0|max:100',
            'logbook' => 'required|numeric|min:0|max:100',
            'presentasi' => 'required|numeric|min:0|max:100',
        ]);

        $evaluation = new Evaluation;
        $evaluation->internship_id = $request->internship_id;
        $evaluation->monitoring = $request->monitoring;
        $evaluation->sertifikat = $request->sertifikat;
        $evaluation->logbook = $request->logbook;
        $evaluation->presentasi = $request->presentasi;
        $evaluation->setFinalScoreAttribute();
        $evaluation->save();
        if($request->wantsJson()){
            return response()->json(['message'=>'Data penilaian berhasil disimpan']);
        }
        return redirect()->route('teacher/evaluation.index')->with('success', 'Penilaian berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        if(request()->wantsJson()){
            return response()->json(['evaluation'=>$evaluation]);
        }
        return view('pages.teacher.penilaian.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        return view('pages.teacher.penilaian.edit', compact('evaluation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'monitoring' => 'required|numeric|min:0|max:100',
            'sertifikat' => 'required|numeric|min:0|max:100',
            'logbook' => 'required|numeric|min:0|max:100',
            'presentasi' => 'required|numeric|min:0|max:100',
        ]);

        $evaluation->monitoring = $request->monitoring;
        $evaluation->sertifikat = $request->sertifikat;
        $evaluation->logbook = $request->logbook;
        $evaluation->presentasi = $request->presentasi;
        $evaluation->setFinalScoreAttribute();
        $evaluation->save();
        if($request->wantsJson()){
            return response()->json(['message'=>'Data penilaian berhasil diperbarui']);
        }
        return redirect()->route('teacher/evaluation.index')->with('success', 'Penilaian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print($id)
    {
        $evaluation = Evaluation::with('internship')->findOrFail($id);
        $studentName = $evaluation->internship->student->nama ?? 'Unknown';
        $studentName = mb_convert_encoding($studentName, 'UTF-8', 'auto'); // Gunakan mb_convert_encoding
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName); // Hanya simpan karakter valid
        $pdf = PDF::loadView('pages.teacher.penilaian.print', compact('evaluation'));
        $fileName = 'Lembar_Penilaian_Akhir_' . $studentName . '.pdf';
        
        
        
        try {
            if (request()->wantsJson()) {
                return response()->json([
                    'file' => $pdf->stream($fileName), // Gunakan 'file' untuk stream
                    'message' => 'Print penilaian berhasil dilakukan'
                ], 200)->header('Content-Type', 'application/pdf');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
        return $pdf->stream($fileName);
    }
}
