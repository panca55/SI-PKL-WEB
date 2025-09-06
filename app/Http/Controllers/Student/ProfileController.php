<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Mayor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the dashboard for the student.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::with('internship')->where('user_id', $user->id)->first();

        if (!$student) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Data diri belum lengkap.'], 404);
            }
            return redirect()->route('student/profile.create')->with('message', 'Silakan lengkapi data diri Anda.');
        }
        if (request()->wantsJson()) {
            $student->internship;
            $student->internship->teacher;
            $student->internship->instructor;
            $student->internship->corporation;
            return response()->json($student, 200);
        }

        return view('pages.student.dashboard', compact('student'));
    }

    /**
     * Display the profile of the student.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Student::with('mayor')->where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile tidak ditemukan.'], 404);
        }

        if (request()->wantsJson()) {
            return response()->json($profile, 200);
        }

        return view('pages.student.profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mayors = Mayor::all();
        $genders = Student::GENDERS;
        $statuses = Student::STATUS;

        if (request()->wantsJson()) {
            return response()->json([
                'mayors' => $mayors,
                'genders' => $genders,
                'statuses' => $statuses,
            ], 200);
        }

        return view('pages.student.profile.create', compact('mayors', 'genders', 'statuses'));
    }

    /**
     * Store a newly created profile.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'mayor_id' => 'required|exists:mayors,id',
            'nisn' => 'required|string|max:255|unique:students',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $student = new Student();
        $student->user_id = $user->id;
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

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/students-images', $filename);
            $student->foto = $filename;
        }

        $student->save();


        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profile berhasil dibuat.', 'profile' => $student], 201);
        }

        return redirect()->route('student/dashboard')->with('success', 'Data diri berhasil disimpan.');
    }

    /**
     * Update the specified profile.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'image|file|max:2048',
        ]);

        $user->name = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $student = Student::where('user_id', $user->id)->firstOrFail();
        $student->nama = $request->nama;
        $student->mayor_id = $request->mayor_id;
        $student->tahun_masuk = $request->tahun_masuk;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->tempat_lahir = $request->tempat_lahir;
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->alamat_siswa = $request->alamat_siswa;
        $student->alamat_ortu = $request->alamat_ortu;
        $student->hp_ortu = $request->hp_ortu;
        $student->hp_siswa = $request->hp_siswa;

        if ($request->hasFile('foto')) {
            if ($student->foto) {
                Storage::delete('public/students-images/' . $student->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/students-images', $filename);
            $student->foto = $filename;
        } elseif ($request->oldImage) {
            $student->foto = $request->oldImage;
        }

        $student->save();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profile berhasil diperbarui.', 'profile' => $student], 200);
        }

        return redirect()->route('student/profile.index')->with('success', 'Profile berhasil diupdate.');
    }

    /**
     * Delete the profile.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->$id)->firstOrFail();

        if ($student->foto) {
            Storage::delete('public/students-images/' . $student->foto);
        }

        $student->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Profile berhasil dihapus.'], 200);
        }

        return redirect()->route('student/dashboard')->with('success', 'Profile berhasil dihapus.');
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = Student::where('user_id', $user->id)->firstOrFail();
        $genders = Student::GENDERS;
        $mayors = Mayor::all();
        return view('pages.student.profile.edit', compact(['user', 'profile', 'genders', 'mayors']));
    }
}
