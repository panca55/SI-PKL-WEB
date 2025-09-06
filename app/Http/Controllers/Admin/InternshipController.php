<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbsensiExport;
use App\Exports\InternshipExport;
use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Corporation;
use App\Models\Mayor;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Absent;

class InternshipController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/internship",
     *     summary="List semua data magang",
     *     tags={"Admin/Internship"},
     *     @OA\Response(response=200, description="List magang")
     * )
     */
    public function index()
    {
        // Ambil semua data internship beserta relasi yang dibutuhkan
        $internships = Internship::with([
            'student.mayor.department', // Relasi ke student, mayor, dan department
            'teacher',                  // Relasi ke teacher
            'corporation'               // Relasi ke corporation
        ])->get();

        // Jika request JSON, kembalikan response JSON
        if (request()->wantsJson()) {
            return response()->json([
                'internships' => $internships
            ], 200);
        }

        // Jika bukan request JSON, kembalikan ke tampilan
        return view('pages.admin.internship.index', compact('internships'));
    }


    /**
     * Show the form for creating a new resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/internship/create",
     *     summary="Form tambah magang",
     *     tags={"Admin/Internship"},
     *     @OA\Response(response=200, description="Form magang")
     * )
     */
    public function create()
    {
        $classes = Mayor::all();
        $corporations = Corporation::all();
        $students = Student::where('status_pkl', 'BELUM PKL')->get();
        $teachers = Teacher::all();

        return view('pages.admin.internship.create', compact(['students', 'teachers', 'corporations', 'classes']));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/admin/internship",
     *     summary="Tambah data magang baru",
     *     tags={"Admin/Internship"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="student_id", type="integer"),
     *                 @OA\Property(property="teacher_id", type="integer"),
     *                 @OA\Property(property="corporation_id", type="integer"),
     *                 @OA\Property(property="tahun_ajaran", type="string"),
     *                 @OA\Property(property="tanggal_mulai", type="string", format="date"),
     *                 @OA\Property(property="tanggal_berakhir", type="string", format="date")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Magang ditambah")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'corporation_id' => 'required|exists:corporations,id',
            'tahun_ajaran' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Valigasi agar tidak ada siswa terdaftar di perusahaan lain
        $isStudentRegistered = Internship::where('student_id', $request->student_id)
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_berakhir])
                    ->orWhereBetween('tanggal_berakhir', [$request->tanggal_mulai, $request->tanggal_berakhir]);
            })
            ->exists();

        if ($isStudentRegistered) {
            return redirect()->route('admin/internship.index')->with('error', 'Siswa sudah terdaftar di perusahaan lain selama periode ini.');
        }

        $corporation = Corporation::find($request->corporation_id);
        $currentCount = Internship::where('corporation_id', $corporation->id)->count();

        if ($currentCount < $corporation->quota) {
            Internship::create([
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id,
                'corporation_id' => $request->corporation_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
            ]);
            $internship = Internship::create([
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id,
                'corporation_id' => $request->corporation_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
            ]);
            Student::where('id', $request->student_id)->update(['status_pkl' => 'SEDANG PKL']);
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Data Magang berhasil ditambahkan',
                    'internship' => $internship,
                ], 200);
            }
            return redirect()->route('admin/internship.index')->with('success', 'Data Magang berhasil ditambahkan.');
        } else {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Kuota perusahaan sudah penuh'], 404);
            }
            return redirect()->route('admin/internship.index')->with('error', 'Kuota perusahaan sudah penuh.');
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/internship/{id}",
     *     summary="Detail magang",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detail magang")
     * )
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/internship/{id}/edit",
     *     summary="Form edit magang",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Form edit magang")
     * )
     */
    public function edit(Internship $internship)
    {
        $students = Student::where('id', $internship->id)->first();
        $teachers = Teacher::all();
        $corporations = Corporation::all();
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Data Magang berhasil dirubah',
                'internship' => $internship,
                'students' => $students,
                'teachers' => $teachers,
                'corporations' => $corporations,
            ], 200);
        }
        return view('pages.admin.internship.edit', compact(['internship', 'students', 'teachers', 'corporations']));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/admin/internship/{id}",
     *     summary="Update data magang",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="student_id", type="integer"),
     *                 @OA\Property(property="teacher_id", type="integer"),
     *                 @OA\Property(property="corporation_id", type="integer"),
     *                 @OA\Property(property="tahun_ajaran", type="string"),
     *                 @OA\Property(property="tanggal_mulai", type="string", format="date"),
     *                 @OA\Property(property="tanggal_berakhir", type="string", format="date")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Magang diupdate")
     * )
     */
    public function update(Request $request, Internship $internship)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'corporation_id' => 'required|exists:corporations,id',
            'tahun_ajaran' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Validasi agar tidak ada siswa terdaftar di perusahaan lain selama periode yang sama
        $isStudentRegistered = Internship::where('student_id', $request->student_id)
            ->where('id', '!=', $internship->id) // Mengecualikan data yang sedang diupdate
            ->where('tahun_ajaran', $request->tahun_ajaran)
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_berakhir])
                    ->orWhereBetween('tanggal_berakhir', [$request->tanggal_mulai, $request->tanggal_berakhir]);
            })
            ->exists();

        if ($isStudentRegistered) {
            return redirect()->route('admin/internship.index')->with('error', 'Siswa sudah terdaftar di perusahaan lain selama periode ini.');
        }

        $corporation = Corporation::find($request->corporation_id);
        $currentCount = Internship::where('corporation_id', $corporation->id)->count();

        if ($currentCount < $corporation->quota || $corporation->id == $internship->corporation_id) {
            // Update data magang
            $internship->update([
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id,
                'corporation_id' => $request->corporation_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
            ]);
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Data Magang berhasil diperbarui',
                    'internship' => $internship,
                ], 200);
            }
            return redirect()->route('admin/internship.index')->with('success', 'Data Magang berhasil diperbarui.');
        } else {
            return redirect()->route('admin/internship.index')->with('error', 'Kuota perusahaan sudah penuh.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/admin/internship/{id}",
     *     summary="Hapus data magang",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Magang dihapus")
     * )
     */
    public function destroy(Internship $internship)
    {
        $student_id = $internship->student_id;
        $internship->delete();
        Student::where('id', $student_id)->update(['status_pkl' => 'BELUM PKL']);
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Data Magang berhasil dihapus',
                'student_id' => $student_id,
                'internship' => $internship,
            ], 200);
        }
        return redirect()->route('admin/internship.index')->with('success', 'Data PKL berhasil dihapus');
    }

    //Bagian Export
    /**
     * @OA\Get(
     *     path="/admin/export",
     *     summary="Export data magang ke Excel",
     *     tags={"Admin/Internship"},
     *     @OA\Response(response=200, description="File Excel")
     * )
     */
    public function exportExcel()
    {
        $date = Carbon::now()->format('d-m-Y');
        $fileName = "siswa-pkl-{$date}.xlsx";

        return Excel::download(new InternshipExport, $fileName);
    }

    /**
     * @OA\Get(
     *     path="/admin/exportAbsent",
     *     summary="Export absensi siswa ke Excel",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="month", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="year", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="File Excel absensi")
     * )
     */
    public function exportAbsent(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        $bulan = Carbon::create($year, $month)->locale('id')->monthName;

        $fileName = "Rekap-Absensi-Siswa-{$bulan}-{$year}.xlsx";

        return Excel::download(new AbsensiExport($month, $year), $fileName);
    }

    //Halaman data sebelum Export

    /**
     * @OA\Get(
     *     path="/admin/rekapAbsensi",
     *     summary="Rekap absensi siswa",
     *     tags={"Admin/Internship"},
     *     @OA\Parameter(name="filter_option", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="month", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="year", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Rekap absensi")
     * )
     */
    public function rekapAbsensi(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $filterOption = $request->input('filter_option', 'all');
        $month = (int) $request->input('month', Carbon::now()->month); // Pastikan sebagai integer
        $year = (int) $request->input('year', $currentYear); // Pastikan sebagai integer

        // Hitung jumlah hari dalam bulan dan tahun yang difilter
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth; // Gunakan hari pertama (1) untuk memastikan data valid

        $internships = Internship::with(['absents', 'student']);

        if ($filterOption === 'monthly') {
            $internships = $internships->whereHas('absents', function ($query) use ($month, $year) {
                $query->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year);
            });
        }

        $internships = $internships->get();

        // Hitung jumlah absensi berdasarkan keterangan
        $rekapData = $internships->map(function ($internship) {
            $absentCounts = [
                'hadir' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alpha' => 0,
            ];

            // Hitung jumlah keterangan absensi
            foreach ($internship->absents as $absent) {
                $keterangan = strtolower($absent->keterangan); // Pastikan lowercase
                if (array_key_exists($keterangan, $absentCounts)) {
                    $absentCounts[$keterangan]++;
                }
            }

            // Total absensi
            $absentCounts['total'] = array_sum($absentCounts);

            return [
                'internship_id' => $internship->id,
                'nisn' => $internship->student->nisn ?? '-',
                'nama' => $internship->student->nama ?? '-',
                'absents' => $absentCounts,
            ];
        });

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Data absensi berhasil direkap',
                'data' => $rekapData,
                'filterOption' => $filterOption,
                'month' => $month,
                'year' => $year,
            ], 200);
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view(
            'pages.admin.internship.rekapAbsensi',
            compact('internships', 'months', 'currentYear', 'month', 'year', 'filterOption', 'daysInMonth')
        );
    }






    /**
     * @OA\Get(
     *     path="/admin/rekapJurnal",
     *     summary="Rekap jurnal siswa",
     *     tags={"Admin/Internship"},
     *     @OA\Response(response=200, description="Rekap jurnal")
     * )
     */
    public function rekapJurnal()
    {
        $internships = Internship::with('logbook')->get();
        return view('pages.admin.internship.rekapJurnal', compact(
            'internships',
        ));
    }

    /**
     * @OA\Get(
     *     path="/admin/internship/all",
     *     summary="Ambil semua data magang beserta absensi dan siswa",
     *     tags={"Admin/Internship"},
     *     @OA\Response(response=200, description="List magang lengkap")
     * )
     */
    public function getAllInternships()
    {
        $internships = Internship::with(['absents', 'student'])->get();
        // $absents = Absent::where('internship_id', $internships)->get();
        // $attendanceDetails = [
        //     'HADIR' => $absents->where('keterangan', 'HADIR')->count(),
        //     'IZIN' => $absents->where('keterangan', 'IZIN')->count(),
        //     'SAKIT' => $absents->where('keterangan', 'SAKIT')->count(),
        //     'ALPHA' => $absents->where('keterangan', 'ALPHA')->count(),
        // ];

        // Struktur data untuk respon
        return response()->json([
            'message' => 'Data berhasil diambil',
            'internships' => $internships,
            // 'kehadiran'=> $attendanceDetails
        ], 200);
    }
}
