<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Instructor;
use App\Models\Internship;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $instructor = Instructor::where('user_id', $user->id)->firstOrFail();
        $internships = Internship::with(['student.mayor.department', 'corporation', 'teacher', 'certificate'])
            ->where('instructor_id', $instructor->id)
            ->where('status', 'AKTIF')
            ->get();
        if(request()->wantsJson()){
            return response()->json([
                'sertifikat'=>$internships,
                ]);
        }
        return view('pages.instructor.sertifikat.index', compact('internships'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function createSertifikat($id)
    {
        $internship = Internship::findOrFail($id);
        $category = Certificate::CATEGORY;
        return view('pages.instructor.sertifikat.create', compact('internship', 'category'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storeSertifikat(Request $request)
    {
        // Validasi input
        $request->validate([
            'internship_id' => 'required|integer',
            'nama_pimpinan' => 'required|string',
            'scores.*.*' => 'nullable|numeric',
            'categories.*.*' => 'nullable|string',
            'predikats.*.*' => 'nullable|string',
        ]);

        // Data dari request
        $internship_id = $request->internship_id;
        $nama_pimpinan = $request->nama_pimpinan;

        // Daftar kategori
        $categories = ['UMUM', 'KOMPETENSI_UTAMA', 'KOMPETENSI_PENUNJANG'];

        // Proses setiap kategori
        try {
            foreach ($categories as $category) {
                if ($request->has("scores.$category")) {
                    foreach ($request->scores[$category] as $index => $score) {
                        Certificate::create([
                            'internship_id' => $internship_id,
                            'category' => str_replace('_', ' ', $category),
                            'nama' => $request->categories[$category][$index] ?? null,
                            'score' => $score,
                            'nama_pimpinan' => $nama_pimpinan,
                            'predikat' => $request->predikats[$category][$index] ?? null,
                        ]);
                    }
                }
            }

            // Jika request adalah JSON
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Sertifikat berhasil dibuat'], 201);
            }

            // Redirect jika bukan API
            return redirect()->route('instructor/sertifikat.index')->with('success', 'Sertifikat berhasil disimpan');
        } catch (\Exception $e) {
            // Penanganan error
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan sertifikat.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        $certificate = Certificate::where('internship_id', $internship->id)->get();
        if(request()->wantsJson()){
            $internship->student->mayor->department;
            $internship->corporation;
            return response()->json([
                'internship' => $internship,
                'data' =>$certificate
            ]);
            }
        return view('pages.instructor.sertifikat.show', compact('internship', 'certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('pages.instructor.sertifikat.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'score' => 'required|integer|min:0|max:100',
            'predikat' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // jika file di-update
        ]);

        // Update sertifikat dengan data baru
        $certificate->nama = $request->nama;
        $certificate->score = $request->score;
        $certificate->predikat = $request->predikat;

        // Jika ada file baru yang di-upload, simpan
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certificates');
            $certificate->file = $path;
        }

        $certificate->save();
        if($request->wantsJson()){
            return response()->json(['message' =>'Sertifikat berhasil diperbarui']);
        }
        return redirect()->route('instructor/sertifikat.show', $certificate->id)->with('success', 'Sertifikat berhasil diperbarui.');
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
        $internship = Internship::findOrFail($id);
        $certificate = Certificate::where('internship_id', $internship->id);
        $studentName = $evaluation->internship->student->nama ?? 'Unknown';
        $studentName = mb_convert_encoding($studentName, 'UTF-8', 'auto'); // Gunakan mb_convert_encoding
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName); // Hanya simpan karakter valid
        $pdf = PDF::loadView('pages.instructor.sertifikat.print', compact('internship', 'certificate'));
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
}
