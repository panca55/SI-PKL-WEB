<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Mayor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function Pest\Laravel\json;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/student",
     *     summary="List semua siswa",
     *     tags={"Admin/Student"},
     *     @OA\Response(response=200, description="List siswa")
     * )
     */
    public function index(Request $request)
    {
        $query = Student::with('mayor.department', 'user');

        // Filter berdasarkan tahun_masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
            session(['filter_tahun_masuk' => $request->tahun_masuk]);
        } else {
            session()->forget('filter_tahun_masuk');
        }

        // Filter berdasarkan mayor_id
        if ($request->filled('mayor_id')) {
            $query->where('mayor_id', $request->mayor_id);
            session(['filter_mayor_id' => $request->mayor_id]);
        } else {
            session()->forget('filter_mayor_id');
        }

        // Dapatkan hasil yang difilter
        $students = $query->paginate(10);  // Menggunakan paginate untuk pagination

        // Ambil data jurusan untuk filter
        $mayors = Mayor::with('department')->get();

        if ($request->wantsJson()) {
            $students = $query->get();
            return response()->json(['students' => $students], 200);
        }

        // Send the filters back to the view to retain the filter selection
        return view('pages.admin.student.index', compact('students', 'mayors'));
    }

    /**
     * @OA\Get(
     *     path="/admin/studentExport",
     *     summary="Export data siswa ke Excel",
     *     tags={"Admin/Student"},
     *     @OA\Response(response=200, description="File Excel siswa")
     * )
     */
    public function studentExport(Request $request)
    {
        $query = Student::with('mayor');

        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
            $tahunMasuk = str_replace('/', '-', $request->tahun_masuk);
        } else {
            $tahunMasuk = 'semua_tahun';
        }

        if ($request->filled('mayor_id')) {
            $query->where('mayor_id', $request->mayor_id);
        }

        $students = $query->get();

        $fileName = 'data_siswa_' . $tahunMasuk . '.xlsx';

        // Export ke Excel (gunakan package Laravel Excel)
        return Excel::download(new StudentsExport($students), $fileName);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'SISWA')->get();
        $mayors = Mayor::all();
        $genders = Student::GENDERS;
        $statuses = Student::STATUS;
        return view('pages.admin.student.create', compact(['users', 'mayors', 'genders', 'statuses']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mayor_id' => 'required|exists:mayors,id',
            'nisn' => 'required|string|max:255|unique:students',
        ]);

        $student = new Student;
        $student->user_id = $request->user_id;
        $student->mayor_id = $request->mayor_id;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->konsentrasi = $request->konsentrasi;
        $student->tahun_masuk = $request->tahun_masuk;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->status_pkl = 'BELUM PKL';
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->tempat_lahir = $request->tempat_lahir;
        $student->alamat_siswa = $request->alamat_siswa;
        $student->alamat_ortu = $request->alamat_ortu;
        $student->hp_siswa = $request->hp_siswa;
        $student->hp_ortu = $request->hp_ortu;
        $student->foto = $request->foto;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/students-images', $filename);
            $student->foto = $filename;
        }

        $student->save();
        if ($request->wantsJson()) {
            return response()->json(['message' => '$Data siswa berhasil ditambahkan'], 200);
        }

        return redirect()->route('admin/student.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $mayors = Mayor::all();
        $genders = Student::GENDERS;
        $statuses = Student::STATUS;
        return view('pages.admin.student.edit', compact(['student', 'mayors', 'genders', 'statuses']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'mayor_id' => 'required|exists:mayors,id',
            'nisn' => 'required|string|max:255',
            'foto' => 'image|file|max:2048',
        ]);

        // Update data siswa
        $student->mayor_id = $request->mayor_id;
        $student->nisn = $request->nisn;
        $student->nama = $request->nama;
        $student->konsentrasi = $request->konsentrasi;
        $student->tahun_masuk = $request->tahun_masuk;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->status_pkl = $request->status_pkl;
        $student->tempat_lahir = $request->tempat_lahir;
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->alamat_siswa = $request->alamat_siswa;
        $student->alamat_ortu = $request->alamat_ortu;
        $student->hp_siswa = $request->hp_siswa;
        $student->hp_ortu = $request->hp_ortu;

        if ($request->hasFile('foto')) {
            if ($student->foto) {
                Storage::delete($student->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/students-images', $filename);
            $student->foto = $filename;
        } else {
            $student->foto = $request->oldImage;
        }
        $student->save();

        // Redirect kembali ke halaman index dengan filter yang tersimpan
        $redirectUrl = route('admin/student.index');
        $queryParams = [];

        if (session('filter_tahun_masuk')) {
            $queryParams['tahun_masuk'] = session('filter_tahun_masuk');
        }
        if (session('filter_mayor_id')) {
            $queryParams['mayor_id'] = session('filter_mayor_id');
        }

        if (!empty($queryParams)) {
            $redirectUrl .= '?' . http_build_query($queryParams);
        }
        if ($request->wantsJson()) {
            return response()->json(['message' => '$Data siswa berhasil diperbarui'], 200);
        }
        return redirect($redirectUrl)->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->foto) {
            Storage::delete($student->foto);
        }

        $student->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Data siswa berhasil dihapus', 'student' => $student], 200);
        }

        return redirect()->route('admin/student.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
