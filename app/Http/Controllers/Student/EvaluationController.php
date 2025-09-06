<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\EvaluationDate;
use App\Models\Feedback;
use App\Models\Internship;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Check if evaluation is available.
     */
    public function checkEvaluationAvailability()
    {
        $currentDate = Carbon::now()->toDateString();

        // Cek apakah ada periode penilaian aktif
        $evaluationDate = EvaluationDate::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();

        return response()->json([
            'is_evaluation_available' => $evaluationDate !== null
        ]);
    }

    /**
     * Display the evaluation details for the student.
     */
    public function index()
{
    $currentDate = Carbon::now()->toDateString();
    $user = Auth::user();

    // Periksa apakah user telah login
    if (!$user) {
        return response()->json(['error' => 'User tidak ditemukan atau belum login.'], 401);
    }

    // Temukan data student berdasarkan user_id
    $student = Student::where('user_id', $user->id)->first();
    if (!$student) {
        return response()->json(['error' => 'Siswa tidak ditemukan.'], 404);
    }

    // Cari data internship terkait student
    $internship = Internship::with('evaluation', 'certificate')
        ->where('student_id', $student->id)->first();

    if (!$internship) {
        if(request()->wantsJson()){
        return response()->json(['message' => 'Masa PKL belum dimulai.'], 404);
        }
        return redirect()->route('student/dashboard')->with('message', 'Masa PKL belum dimulai.');
    }

    $feedback = Feedback::where('student_id', $student->id)->first();
    $evaluationDate = EvaluationDate::where('start_date', '<=', $currentDate)
        ->where('end_date', '>=', $currentDate)
        ->first();

    $isEvaluationEmpty = empty($internship->evaluation);
        if (request()->wantsJson()) {
            return response()->json([
                'internship' => [
                    'id' => $internship->id,
                    'evaluation' => $internship->evaluation ? [
                        'monitoring' => $internship->evaluation->monitoring,
                        'sertifikat' => $internship->evaluation->sertifikat,
                        'logbook' => $internship->evaluation->logbook,
                        'presentasi' => $internship->evaluation->presentasi,
                        'nilai_akhir' => $internship->evaluation->nilai_akhir,
                    ] : null,
                    'certificate' => $internship->certificate,
                ],
                'feedback' => $feedback,
                'evaluation_date' => $evaluationDate,
                'is_evaluation_empty' => $isEvaluationEmpty,
            ], 200);
        }
    return view('pages.student.evaluation.index', compact('internship', 'feedback', 'evaluationDate', 'isEvaluationEmpty'));
}


    /**
     * Store a new feedback for the internship.
     */
    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Periksa apakah user telah login
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan atau belum login.'], 401);
        }

        $student = Student::where('user_id', $user->id)->first();
        if (!$student) {
            return response()->json(['error' => 'Siswa tidak ditemukan.'], 404);
        }

        $internship = Internship::where('student_id', $student->id)->first();
        if (!$internship) {
            return response()->json(['error' => 'Masa PKL belum dimulai.'], 404);
        }

        $feedback = Feedback::create([
            'student_id' => $student->id,
            'corporation_id' => $internship->corporation_id,
            'komentar' => $request->komentar,
        ]);

        // Update status student
        $student->update(['status_pkl' => 'SUDAH PKL']);
        if (request()->wantsJson()) {
        return response()->json([
        'message' => 'Feedback berhasil dikirim. Sekarang Anda dapat mengunduh sertifikat.',
        'feedback' => $feedback,
    ],201);}
        return redirect()->back()->with('success', 'Feedback berhasil dikirim. Sekarang Anda dapat mengunduh sertifikat.');
    }


    /**
     * Generate and return a PDF certificate for the internship.
     */
    public function print($id)
    {
        $internship = Internship::find($id);
        if (!$internship) {
            return response()->json(['error' => 'Data PKL tidak ditemukan.'], 404);
        }

        $certificate = Certificate::where('internship_id', $internship->id)->get();
        if ($certificate->isEmpty()) {
            return response()->json(['error' => 'Sertifikat tidak tersedia.'], 404);
        }

        $studentName = str_replace(' ', '_', $internship->student->nama);
        $fileName = 'Sertifikat_' . $studentName . '.pdf';

        $pdf = PDF::loadView('pages.student.evaluation.print-sertifikat', compact('internship', 'certificate'))
            ->setPaper('a4', 'landscape');

        // Return PDF as base64 for API response
        $base64Pdf = base64_encode($pdf->output());
        if (request()->wantsJson()) {
        return response()->json([
            'file_name' => $fileName,
            'file_content' => $base64Pdf,
        ],);
        }
        return $pdf->stream($fileName);
    }
}

