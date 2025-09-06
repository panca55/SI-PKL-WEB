<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EvaluationsExport;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\EvaluationDate;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Internship;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MonitoringAssessment;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internships = Internship::with('student.mayor.department', 'teacher', 'corporation','evaluation', 'assessment', 'certificate')->get();
        $evaluations = Evaluation::with('evaluationDate')->get();
        $evaluationDates = EvaluationDate::all();
        if (request()->wantsJson()) {
            return response()->json([
                'internships' => $internships,
                'evaluations' => $evaluations,
                'evaluationDates' => $evaluationDates,
            ], 200);
        }
        return view('pages.admin.evaluation.index', compact('internships', 'evaluations', 'evaluationDates'));
    }

    public function evaluationExel()
    {
        $date = Carbon::now()->format('d-m-Y');
        $fileName = "nilai-akhir-siswa-pkl-{$date}.xlsx";

        return Excel::download(new EvaluationsExport, $fileName);
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
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Simpan tanggal penilaian ke dalam database
        EvaluationDate::create($validatedData);
        if ($request->wantsJson()) {
            return response()->json([
                'validatedData' => $validatedData,
                'message' => 'Tanggal penilaian berhasil dibuat.',
            ], 200);
        }
        return redirect()->route('admin/evaluation.index')->with('success', 'Tanggal penilaian berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $internships = Internship::with('evaluation', 'assessment')->findOrFail($id);
        $certificate = Certificate::where('internship_id', $internships->id)
            ->get();
        if (request()->wantsJson()) {
            return response()->json([
                'internships' => $internships,
                'certificate' => $certificate,
            ], 200);
        }
        return view('pages.admin.evaluation.show', compact('internships', 'certificate'));
    }

    public function detail($id)
    {
        $assessment = MonitoringAssessment::findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json([
                'assessment' => $assessment,
            ], 200);
        }
        return view('pages.admin.evaluation.detail', compact('assessment'));
    }

    public function printSelected(Request $request, $internshipId)
    {
        $internship = Internship::findOrFail($internshipId);
        $selectedIds = $request->input('selected_assessments', []);
        $assessments = $internship->assessment()->whereIn('id', $selectedIds)->get();

        $studentName = $internship->student->nama;
        $studentName = str_replace(' ', '_', $studentName);

        $pdf = PDF::loadView('pages.admin.evaluation.print-monitoring', compact('assessments', 'internship'));
        $fileName = 'Penilaian_Monitoring_' . $studentName . '.pdf';
        return $pdf->download($fileName);
    }

    public function printSertifikat($id)
    {
        $internship = Internship::findOrFail($id);
        $certificate = Certificate::where('internship_id', $internship->id)->get();
        $studentName = $internship->student->nama;
        $studentName = str_replace(' ', '_', $studentName);
        $pdf = PDF::loadView('pages.admin.evaluation.print-sertifikat', compact('internship', 'certificate'))->setPaper('a4', 'landscape');
        $fileName = 'Sertifikat_' . $studentName . '.pdf';
        try {
            if (request()->wantsJson()) {
                return response()->json([
                    'file' => $pdf->stream($fileName), // Gunakan 'file' untuk stream
                    'message' => 'Print sertifikat berhasil dilakukan'
                ], 200)->header('Content-Type', 'application/pdf');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
        return $pdf->stream($fileName, ['Attachment' => false]);
    }

    public function printNilaiakhir($id)
    {
        $evaluation = Evaluation::with('internship')->findOrFail($id);
        $studentName = $evaluation->internship->student->nama;
        $studentName = str_replace(' ', '_', $studentName);
        $pdf = PDF::loadView('pages.admin.evaluation.print-nilaiAkhir', compact('evaluation'));
        $fileName = 'Lembar_Penilaian_Akhir_' . $studentName . '.pdf';
        return $pdf->stream($fileName);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.admin.evaluation.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Temukan tanggal penilaian yang ingin diupdate
        $evaluationDate = EvaluationDate::findOrFail($id);

        // Update data tanggal penilaian
        $evaluationDate->update($validatedData);
        if ($request->wantsJson()) {
            return response()->json([
                'evaluationDate' => $evaluationDate,
                'validatedData' => $validatedData,
                'message' => 'Evaluasi berhasil diupdate',
            ], 200);
        }

        return redirect()->route('admin/evaluation.index')->with('success', 'Tanggal penilaian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
