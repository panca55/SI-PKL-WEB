<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Absent;
use App\Models\Logbook;
use App\Models\Student;
use Carbon\CarbonPeriod;
use App\Models\Internship;
use App\Models\Corporation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->first();
        if (!$internship) {
            return redirect()->route('student/dashboard')->with('message', 'Masa PKL belum dimulai.');
        }
        $tanggal_mulai = $internship->tanggal_mulai;
        $tanggal_berakhir = $internship->tanggal_berakhir;
        $today = Carbon::now();
        if ($today->lt($tanggal_mulai)) {
            $status = 'before';
        } elseif ($today->gt($tanggal_berakhir)) {
            $status = 'after';
        } else {
            $status = 'during';
        }
        // Ambil data absent dan logbook berdasarkan internship yang ditemukan
        $absents = Absent::where('internship_id', $internship->id)->get();
        $logbooks = Logbook::where('internship_id', $internship->id)
            ->whereDate('created_at', $today)
            ->get();

        $todayAbsence = Absent::where('internship_id', $internship->id)
            ->whereDate('created_at', $today)
            ->exists();

        $cekHadir = Absent::where('internship_id', $internship->id)
            ->where('keterangan', 'HADIR')
            ->whereDate('created_at', $today)
            ->exists();

        $workStartTime = Carbon::parse($internship->corporation->jam_mulai);
        $workEndTime = Carbon::parse($internship->corporation->jam_berakhir);

        // Cek apakah sekarang berada dalam rentang jam kerja
        $jamKerja = $today->between($workStartTime, $workEndTime);
        // Calculate attendance percentage
        $startDate = Carbon::parse($internship->tanggal_mulai);
        $endDate = Carbon::parse($internship->tanggal_berakhir);
        $period = CarbonPeriod::create($startDate, $endDate);

        // Assuming company works Monday to Friday
        $workDays = $period->filter('isWeekday')->count();

        $totalAttendanceDays = Absent::where('internship_id', $internship->id)
            ->where('keterangan', 'HADIR')
            ->count();

        $attendancePercentage = ($totalAttendanceDays / $workDays) * 100;

        $attendanceDetails = [
            'HADIR' => $absents->where('keterangan', 'HADIR')->count(),
            'IZIN' => $absents->where('keterangan', 'IZIN')->count(),
            'SAKIT' => $absents->where('keterangan', 'SAKIT')->count(),
            'ALPHA' => $absents->where('keterangan', 'ALPHA')->count(),
        ];
        if (request()->wantsJson()) {
            return response()->json(['intership' => $internship, 'status' => $status, 'presentase_kehadiran' => $attendancePercentage, 'detail_kehadiran' => $attendanceDetails, 'kehadiran_hari_ini' => $todayAbsence, 'cek_hadir' => $cekHadir, 'jam_kerja' => $jamKerja, 'logbook' => $logbooks], 200);
        }
        // Menghitung persentase kehadiran
        return view('pages.student.internship.index', compact(
            'internship',
            'status',
            'attendancePercentage',
            'attendanceDetails',
            'todayAbsence',
            'cekHadir',
            'jamKerja',
            'logbooks'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Logbook::CATEGORY;
        $assigments = Logbook::ASSIGNMENT;
        $activities = Logbook::ACTIVITY;
        if (request()->wantsJson()) {
            return response()->json([
                'categories' => $categories,
                'assigments' => $assigments,
                'activities' => $activities,
            ], 200);
        }
        return view('pages.student.internship.create', compact(
            'categories',
            'assigments',
            'activities',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug endpoint untuk testing
        if ($request->has('debug')) {
            return response()->json([
                'message' => 'Debug mode',
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
                'all_inputs' => $request->all(),
                'all_files' => $request->allFiles(),
                'has_file' => $request->hasFile('file'),
                'has_photo' => $request->hasFile('photo'),
                'keterangan' => $request->input('keterangan')
            ]);
        }

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->firstOrFail();

        $corporation = Corporation::find($internship->corporation_id);

        $today = Carbon::today('Asia/Jakarta');
        $startDate = Carbon::parse($internship->tanggal_mulai);
        $endDate = Carbon::parse($internship->tanggal_berakhir);
        $currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');

        if ($today->lessThan($startDate) || $today->greaterThan($endDate)) {
            return response()->json(['success' => false, 'message' => 'Absensi hanya bisa diisi dalam rentang tanggal internship.']);
        }

        $dayOfWeek = $today->isoFormat('dddd');
        $workingDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        if (!in_array($dayOfWeek, $workingDays)) {
            return response()->json(['success' => false, 'message' => 'Absensi hanya bisa diisi pada hari kerja perusahaan.']);
        }

        $keterangan = $request->input('keterangan');

        // Validasi jam kerja hanya jika status kehadiran adalah HADIR
        if ($keterangan === 'HADIR') {
            if ($currentTime < $corporation->jam_mulai || $currentTime > $corporation->jam_berakhir) {
                return response()->json(['success' => false, 'message' => 'Absensi hanya bisa diisi pada jam kerja perusahaan.']);
            }
        }

        $photoName = null;
        $filePath = null;

        // Debug: Log semua input yang diterima
        Log::info('Request data:', [
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'keterangan' => $keterangan,
            'has_file' => $request->hasFile('file'),
            'files' => $request->allFiles(),
            'all_input' => $request->all(),
            'request_size' => strlen($request->getContent()),
            'php_input_size' => strlen(file_get_contents('php://input'))
        ]);

        if ($keterangan === 'HADIR') {
            // Periksa berbagai kemungkinan field name untuk file
            $fileField = null;
            $uploadedFile = null;

            // Cek field name yang umum digunakan
            foreach (['file', 'photo', 'image', 'foto'] as $fieldName) {
                if ($request->hasFile($fieldName)) {
                    $fileField = $fieldName;
                    $uploadedFile = $request->file($fieldName);
                    break;
                }
            }

            if ($uploadedFile) {
                $request->validate([
                    $fileField => 'required|image|mimes:jpeg,jpg,png|max:2048',
                ]);
                $photoName = date('Ymd') . '_' . Str::slug($student->nama) . '.' . $uploadedFile->getClientOriginalExtension();
                // Simpan ke storage/app/public/Absents-Siswa
                $filePath = $uploadedFile->storeAs('Absents-Siswa', $photoName, 'public');
            } else {
                // Fallback: Cek input base64 dengan berbagai field name
                $photoData = null;
                $base64Fields = ['photo', 'image', 'file', 'foto', 'photo_base64', 'image_data'];

                foreach ($base64Fields as $fieldName) {
                    if ($request->has($fieldName) && !empty($request->input($fieldName))) {
                        $photoData = $request->input($fieldName);
                        break;
                    }
                }

                if ($photoData) {
                    // Bersihkan base64 string
                    $photoData = preg_replace('#^data:image/\w+;base64,#i', '', $photoData);
                    $photoData = str_replace(' ', '+', $photoData);

                    // Validasi base64
                    if (base64_decode($photoData, true) === false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Format base64 image tidak valid.'
                        ], 422);
                    }

                    $photoName = date('Ymd') . '_' . Str::slug($student->nama) . '.jpg';
                    Storage::disk('public')->put('Absents-Siswa/' . $photoName, base64_decode($photoData));
                    $filePath = 'Absents-Siswa/' . $photoName;
                } else {
                    // Tidak ada file atau base64 yang ditemukan
                    return response()->json([
                        'success' => false,
                        'message' => 'Foto absensi tidak ditemukan. Kirim file via multipart atau base64.',
                        'debug' => [
                            'received_files' => array_keys($request->allFiles()),
                            'received_inputs' => array_keys($request->all()),
                            'content_type' => $request->header('Content-Type'),
                            'supported_fields' => 'Multipart: file,photo,image,foto | Base64: photo,image,file,foto,photo_base64,image_data'
                        ]
                    ], 422);
                }
            }
        } else {
            // Validasi file surat izin (PDF atau gambar)
            $request->validate([
                'file' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            ]);

            // Simpan file surat izin
            $file = $request->file('file');
            $fileName = date('Ymd') . '_' . Str::slug($student->nama) . '_surat_izin.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Surat-Izin-Siswa', $fileName, 'public');
        }

        // Simpan absensi
        $absent = new Absent();
        $absent->internship_id = $internship->id;
        $absent->tanggal = $today->format('Y-m-d');
        $absent->keterangan = $keterangan;
        $absent->deskripsi = $keterangan === 'HADIR' ? null : $filePath; // null jika HADIR
        $absent->photo = $keterangan === 'HADIR' ? $photoName : null; // simpan nama file jika HADIR
        $absent->validasi = $keterangan === 'HADIR' || $keterangan === 'SAKIT' || $keterangan === 'IZIN' ? true : false; // otomatis valid jika HADIR
        $absent->save();
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Absensi berhasil disimpan', 'absent' => $absent], 201);
        }
        return response()->json(['success' => true, 'message' => 'Absensi berhasil disimpan.']);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $logbook = Logbook::with('note')
            ->findOrFail($id);
        $noteGuru = Note::where('logbook_id', $logbook->id)->where('note_type', 'GURU')->first();
        $noteInstruktur = Note::where('logbook_id', $logbook->id)->where('note_type', 'INSTRUKTUR')->first();
        if (request()->wantsJson()) {
            return response()->json([
                'logbook' => $logbook,
                'note_guru' => $noteGuru,
                'note_instruktur' => $noteInstruktur,
            ], 200);
        }
        return view('pages.student.internship.show', compact(
            'logbook',
            'noteGuru',
            'noteInstruktur',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $logbook = Logbook::findOrFail($id);
        $categories = Logbook::CATEGORY;
        $assigments = Logbook::ASSIGNMENT;
        $activities = Logbook::ACTIVITY;
        if (request()->wantsJson()) {
            return response()->json([
                'logbook' => $logbook,
                'categories' => $categories,
                'assigments' => $assigments,
                'activities' => $activities,
            ], 200);
        }
        return view('pages.student.internship.edit', compact(
            'logbook',
            'categories',
            'assigments',
            'activities',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->firstOrFail();

        // Validasi input dengan kondisi untuk bentuk_kegiatan dan penugasan_pekerjaan
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'isi' => 'required|string|min:10',
            'category' => 'required|string|in:KOMPETENSI,LAINNYA',
            'bentuk_kegiatan' => 'required_if:category,KOMPETENSI|string|max:255',
            'penugasan_pekerjaan' => 'required_if:category,LAINNYA|string|max:255',
        ], [
            'judul.required' => 'Judul logbook wajib diisi.',
            'judul.string' => 'Judul logbook harus berupa teks.',
            'judul.max' => 'Judul logbook maksimal 255 karakter.',
            'foto_kegiatan.image' => 'Bukti kegiatan harus berupa gambar.',
            'foto_kegiatan.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'foto_kegiatan.max' => 'Ukuran gambar maksimal 5MB.',
            'isi.required' => 'Isi logbook tidak boleh kosong.',
            'isi.min' => 'Isi logbook minimal harus 10 karakter.',
            'isi.string' => 'Isi logbook harus berupa teks.',
            'category.required' => 'Kategori logbook wajib dipilih.',
            'category.in' => 'Kategori logbook harus KOMPETENSI atau LAINNYA.',
            'bentuk_kegiatan.required_if' => 'Bentuk kegiatan wajib diisi untuk kategori KOMPETENSI.',
            'bentuk_kegiatan.string' => 'Bentuk kegiatan harus berupa teks.',
            'bentuk_kegiatan.max' => 'Bentuk kegiatan maksimal 255 karakter.',
            'penugasan_pekerjaan.required_if' => 'Penugasan pekerjaan wajib diisi untuk kategori LAINNYA.',
            'penugasan_pekerjaan.string' => 'Penugasan pekerjaan harus berupa teks.',
            'penugasan_pekerjaan.max' => 'Penugasan pekerjaan maksimal 255 karakter.',
        ]);

        $logbook = Logbook::findOrFail($id);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = now()->format('Y-m-d') . '_' . Str::slug($student->nama) . '_kegiatan.' . $extension;

            // Simpan ke storage/app/public/foto-kegiatan (konsisten dengan logbookStore)
            $path = $file->storeAs('foto-kegiatan', $filename, 'public');

            if ($logbook->foto_kegiatan) {
                Storage::delete('foto-kegiatan/' . $logbook->foto_kegiatan);
            }
            $logbook->foto_kegiatan = $filename;
        }

        $logbook->judul = $request->input('judul');
        $logbook->category = $request->input('category');
        $logbook->tanggal = now()->format('Y-m-d');
        $logbook->mulai = $request->input('mulai');
        $logbook->selesai = $request->input('selesai');
        $logbook->petugas = $request->input('petugas');
        $logbook->isi = $request->input('isi');
        $logbook->keterangan = $request->input('keterangan');

        // Update data sesuai kategori
        if ($request->input('category') === 'KOMPETENSI') {
            $logbook->bentuk_kegiatan = $request->input('bentuk_kegiatan');
            $logbook->penugasan_pekerjaan = null;
        } elseif ($request->input('category') === 'LAINNYA') {
            $logbook->penugasan_pekerjaan = $request->input('penugasan_pekerjaan');
            $logbook->bentuk_kegiatan = null;
        }
        // Simpan perubahan ke database
        $logbook->save();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Logbook berhasil diperbarui.',
                'logbook' => $logbook,
                'bukti_kegiatan_url' => $logbook->foto_kegiatan ? asset('storage/foto-kegiatan/' . $logbook->foto_kegiatan) : null
            ], 200);
        }
        return redirect()->route('student/internship.index')->with('success', 'Logbook berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $logbook = Logbook::findOrFail($id);

        if ($logbook->foto_kegiatan) {
            // Pastikan path file benar
            $filePath = 'foto-kegiatan/' . $logbook->foto_kegiatan;

            // Cek apakah file ada sebelum menghapus
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        $logbook->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Logbook berhasil dihapus.'], 200);
        }

        return redirect()->route('student/internship.index')->with('success', 'Logbook berhasil dihapus.');
    }

    public function logbookStore(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->first();

        // Validasi absensi
        $currentDate = Carbon::now()->toDateString();
        $existingAbsence = Absent::where('internship_id', $internship->id)
            ->where('tanggal', $currentDate)
            ->where('keterangan', 'HADIR')
            ->first();

        if ($existingAbsence) {
            // Validasi input - foto_kegiatan WAJIB untuk API POST
            $request->validate([
                'judul' => 'required|string|max:255',
                'foto_kegiatan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'isi' => 'required|string|min:10',
                'category' => 'required|string|in:KOMPETENSI,LAINNYA',
                'bentuk_kegiatan' => 'required_if:category,KOMPETENSI|string|max:255',
                'penugasan_pekerjaan' => 'required_if:category,LAINNYA|string|max:255',
            ], [
                'foto_kegiatan.required' => 'Bukti kegiatan (foto) wajib diupload.',
                'foto_kegiatan.image' => 'Bukti kegiatan harus berupa gambar.',
                'foto_kegiatan.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
                'foto_kegiatan.max' => 'Ukuran gambar maksimal 5MB.',
                'isi.required' => 'Isi logbook tidak boleh kosong.',
                'isi.min' => 'Isi logbook minimal harus 10 karakter.',
                'category.required' => 'Kategori logbook wajib dipilih.',
                'category.in' => 'Kategori logbook harus KOMPETENSI atau LAINNYA.',
                'bentuk_kegiatan.required_if' => 'Bentuk kegiatan wajib diisi untuk kategori KOMPETENSI.',
                'bentuk_kegiatan.string' => 'Bentuk kegiatan harus berupa teks.',
                'bentuk_kegiatan.max' => 'Bentuk kegiatan maksimal 255 karakter.',
                'penugasan_pekerjaan.required_if' => 'Penugasan pekerjaan wajib diisi untuk kategori LAINNYA.',
                'penugasan_pekerjaan.string' => 'Penugasan pekerjaan harus berupa teks.',
                'penugasan_pekerjaan.max' => 'Penugasan pekerjaan maksimal 255 karakter.',
            ]);

            if ($request->hasFile('foto_kegiatan')) {
                $file = $request->file('foto_kegiatan');
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = $currentDate . '_' . Str::slug($student->nama) . '_kegiatan.' . $extension;

                // Simpan ke storage/app/public/foto-kegiatan
                $path = $file->storeAs('foto-kegiatan', $filename, 'public');

                if (!$path) {
                    if ($request->wantsJson()) {
                        return response()->json(['message' => 'Gagal menyimpan bukti kegiatan.'], 500);
                    }
                    return redirect()->route('student/internship.index')->with('error', 'Gagal menyimpan bukti kegiatan.');
                }
            } else {
                // Ini seharusnya tidak pernah terjadi karena validasi required
                if ($request->wantsJson()) {
                    return response()->json(['message' => 'Bukti kegiatan wajib diupload.'], 422);
                }
                return redirect()->route('student/internship.index')->with('error', 'Bukti kegiatan wajib diupload.');
            }

            // Inisialisasi data logbook
            $logbookData = [
                'internship_id' => $internship->id,
                'judul' => $request->judul,
                'category' => $request->category,
                'tanggal' => now()->format('Y-m-d'),
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
                'petugas' => $request->petugas,
                'isi' => $request->isi,  // Pastikan data 'isi' disimpan
                'foto_kegiatan' => $filename,
                'keterangan' => $request->keterangan,
            ];

            // Simpan data sesuai kategori
            if ($request->category === 'KOMPETENSI') {
                $logbookData['bentuk_kegiatan'] = $request->bentuk_kegiatan;
                $logbookData['penugasan_pekerjaan'] = null;
            } elseif ($request->category === 'LAINNYA') {
                $logbookData['penugasan_pekerjaan'] = $request->penugasan_pekerjaan;
                $logbookData['bentuk_kegiatan'] = null;
            }

            Logbook::create($logbookData);
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Logbook berhasil disimpan.',
                    'logbook' => $logbookData,
                    'bukti_kegiatan_url' => asset('storage/foto-kegiatan/' . $filename)
                ], 201);
            }

            return redirect()->route('student/internship.index')->with('success', 'Logbook berhasil disimpan.');
        } else {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Isi absensi terlebih dahulu.'], 401);
            }
            return redirect()->route('student/internship.index')->with('error', 'Isi absensi terlebih dahulu.');
        }
    }

    //DETAIL ABSEN
    public function attendanceDetail(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $internship = Internship::where('student_id', $student->id)->firstOrFail();

        $startDate = $internship->tanggal_mulai;
        $endDate = $internship->tanggal_berakhir;

        $attendances = $internship->absents()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $weeks = $this->getWeeks($startDate, $endDate);
        $months = $this->getMonths($startDate, $endDate);

        return view('pages.student.internship.attendance', compact('attendances', 'weeks', 'months'));
    }

    private function getWeeks($startDate, $endDate)
    {
        $weeks = [];
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while ($currentDate <= $endDate) {
            $weekStart = $currentDate->copy()->startOfWeek();
            $weekEnd = $currentDate->copy()->endOfWeek();
            $weeks[] = [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
                'label' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M')
            ];
            $currentDate->addWeek();
        }

        return $weeks;
    }

    private function getMonths($startDate, $endDate)
    {
        $months = [];
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while ($currentDate <= $endDate) {
            $months[] = [
                'value' => $currentDate->format('Y-m'),
                'label' => $currentDate->format('F Y')
            ];
            $currentDate->addMonth();
        }

        return $months;
    }
}
