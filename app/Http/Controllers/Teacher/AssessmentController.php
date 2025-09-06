<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\MonitoringAssessment;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['instructor','corporation','teacher', 'student.mayor.department', 'assessment'])
            ->where('teacher_id', $teacher->id)
            ->where('status', 'AKTIF')
            ->get();
        if(request()->wantsJson()){
            return response()->json(
                ['monitoring'=> ['internship'=> $internships], 'message'=>'data assessment berhasil diambil']
            );
        }
        return view('pages.teacher.monitoring.index', compact('internships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAssessment($id)
    {
        $internship = Internship::with('assessment')->findOrFail($id);

        // Batasi jumlah penilaian maksimal 5
        if ($internship->assessment->count() >= 5) {
            return redirect()->route('teacher/monitoring.index')->with('error', 'Penilaian sudah mencapai batas maksimal (5 kali).');

        }
        return view('pages.teacher.monitoring.create', compact('internship'));
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
        $internship = $request->internship_id;

        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'nama' => 'required|string|max:255',
            'softskill' => 'required|integer|between:0,100',
            'norma' => 'required|integer|between:0,100',
            'teknis' => 'required|integer|between:0,100',
            'pemahaman' => 'required|integer|between:0,100',
            'catatan' => 'nullable|string',
            'score' => 'required|numeric|between:0,100',
            'deskripsi_softskill' => 'nullable|string',
            'deskripsi_norma' => 'nullable|string',
            'deskripsi_teknis' => 'nullable|string',
            'deskripsi_pemahaman' => 'nullable|string',
            'deskripsi_catatan' => 'nullable|string',
        ]);

        $assessment = new MonitoringAssessment;
        $assessment->internship_id = $internship;
        $assessment->nama = $request->nama;
        $assessment->softskill = $request->softskill;
        $assessment->norma = $request->norma;
        $assessment->teknis = $request->teknis;
        $assessment->pemahaman = $request->pemahaman;
        $assessment->catatan = $request->catatan;
        $assessment->score = $request->score;
        $assessment->deskripsi_softskill = $request->deskripsi_softskill;
        $assessment->deskripsi_norma = $request->deskripsi_norma;
        $assessment->deskripsi_teknis = $request->deskripsi_teknis;
        $assessment->deskripsi_pemahaman = $request->deskripsi_pemahaman;
        $assessment->deskripsi_catatan = $request->deskripsi_catatan;

        $assessment->save();
        if($request->wantsJson()){
            return response()->json(['message'=>'Data penilaian berhasil ditambahkan']);
        }
        return redirect()->route('teacher/assessment.index')->with('success', 'Penilaian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        $assessments = MonitoringAssessment::where('internship_id', $internship->id)
            ->get();
        if(request()->wantsJson()){
            $internship->student;
            $internship->corporation;
            $internship->instructor;
            $internship->teacher;
            $internship->student->mayor->department;
            return response()->json([
                'internship'=>$internship,
                'assessments'=>$assessments,
            ]);
        }
        return view('pages.teacher.monitoring.show', compact('internship', 'assessments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assessment = MonitoringAssessment::findOrFail($id);
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['teacher', 'student', 'assessment'])
            ->where('teacher_id', $teacher->id)
            ->where('status', 'AKTIF')
            ->get();
        if(request()->wantsJson()){
            return response()->json([
                'internship'=>$internships,
                'assessment'=>$assessment,
            ]);
        }
        return view('pages.teacher.monitoring.edit', compact('assessment', 'internships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
        ]);
        $assessment = MonitoringAssessment::findOrFail($id);

        $assessment->update([
            'nama' => $request->input('nama'),
            'internship_id' => $request->input('internship_id'),
            'softskill' => $request->input('softskill'),
            'deskripsi_softskill' => $request->input('deskripsi_softskill'),
            'norma' => $request->input('norma'),
            'deskripsi_norma' => $request->input('deskripsi_norma'),
            'teknis' => $request->input('teknis'),
            'deskripsi_teknis' => $request->input('deskripsi_teknis'),
            'pemahaman' => $request->input('pemahaman'),
            'deskripsi_pemahaman' => $request->input('deskripsi_pemahaman'),
            'catatan' => $request->input('catatan'),
            'score' => $request->input('score'),
            'deskripsi_catatan' => $request->input('deskripsi_catatan'),
        ]);
        if($request->wantsJson()){
            return response()->json(['message'=>'Data penilaian berhasil diperbarui']);
        }
        return redirect()->route('teacher/assessment.index')->with('success', 'Penilaian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function detail($id)
    {
        $assessment = MonitoringAssessment::findOrFail($id);
        if(request()->wantsJson()){
            $assessment->internship;
            $assessment->internship->student->mayor->department;
            $assessment->internship->corporation;
            $assessment->internship->instructor;
            $assessment->internship->teacher;
            return response()->json([
                'assessment'=>$assessment,
            ]);
        }
        return view('pages.teacher.monitoring.detail', compact('assessment'));
    }

    public function print($id)
    {
        $assessment = MonitoringAssessment::with('internship')->findOrFail($id);

        // Pastikan nama mahasiswa dalam encoding UTF-8
        $studentName = $assessment->internship->student->nama ?? 'Unknown';
        $studentName = mb_convert_encoding($studentName, 'UTF-8', 'auto'); // Gunakan mb_convert_encoding
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName); // Hanya simpan karakter valid

        $pdf = PDF::loadView('pages.teacher.monitoring.print', compact('assessment'));

        $fileName = 'Lembar_Penilaian_Monitoring_' . $studentName . '.pdf';

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

        return $pdf->stream($fileName, ['Attachment' => false]);
    }

}
