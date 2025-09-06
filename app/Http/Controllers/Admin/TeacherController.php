<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/teacher",
     *     summary="List semua guru",
     *     tags={"Admin/Teacher"},
     *     @OA\Response(response=200, description="List guru")
     * )
     */
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        if (request()->wantsJson()) {
            // $teachers->user->email;
            return response()->json(['teachers' => $teachers], 200);
        }
        return view('pages.admin.teacher.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $users = User::where('role', 'GURU')->get();
        $genders = Teacher::GENDERS;
        $golonganPNS = [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];
        return view('pages.admin.teacher.create', compact(['users', 'genders', 'golonganPNS']));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/teacher",
     *     summary="Form tambah guru",
     *     tags={"Admin/Teacher"},
     *     @OA\Response(response=200, description="Form guru")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:255|unique:teachers',
            'jenis_kelamin' => 'required|in:' . implode(',', array_keys(Teacher::GENDERS)),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $teacher = new Teacher;
        $teacher->user_id = $request->user_id;
        $teacher->nip = $request->nip;
        $teacher->nama = $request->nama;
        $teacher->golongan = $request->golongan;
        $teacher->bidang_studi = $request->bidang_studi;
        $teacher->pendidikan_terakhir = $request->pendidikan_terakhir;
        $teacher->jabatan = $request->jabatan;
        $teacher->jenis_kelamin = $request->jenis_kelamin;
        $teacher->tanggal_lahir = $request->tanggal_lahir;
        $teacher->tempat_lahir = $request->tempat_lahir;
        $teacher->alamat = $request->alamat;
        $teacher->hp = $request->hp;
        $teacher->foto = $request->foto;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $teacher->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/teachers-images', $filename);
            $teacher->foto = $filename;
        }

        $teacher->save();
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data guru berhasil ditambahkan', 'teacher' => $teacher], 200);
        }

        return redirect()->route('admin/teacher.index')->with('success', 'Data Guru berhasil ditambahkan.');
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
        $teacher = Teacher::findOrFail($id);
        $genders = Teacher::GENDERS;
        $golonganPNS = [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];
        return view('pages.admin.teacher.edit', compact(['teacher', 'genders', 'golonganPNS']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        // Update data teacher
        $teacher->nip = $request->nip;
        $teacher->nama = $request->nama;
        $teacher->golongan = $request->golongan;
        $teacher->bidang_studi = $request->bidang_studi;
        $teacher->pendidikan_terakhir = $request->pendidikan_terakhir;
        $teacher->jabatan = $request->jabatan;
        $teacher->jenis_kelamin = $request->jenis_kelamin;
        $teacher->tanggal_lahir = $request->tanggal_lahir;
        $teacher->tempat_lahir = $request->tempat_lahir;
        $teacher->alamat = $request->alamat;
        $teacher->hp = $request->hp;
        $teacher->foto = $request->foto;

        if ($request->hasFile('foto')) {
            if ($teacher->foto) {
                Storage::delete($teacher->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $teacher->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/teachers-images', $filename);
            $teacher->foto = $filename;
        } else {
            $teacher->foto = $request->oldImage;
        }
        dd($request->all());
        $teacher->save();
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data guru berhasil diperbarui'], 200);
        }
        return redirect()->route('admin/teacher.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->foto) {
            Storage::delete($teacher->foto);
        }

        $teacher->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Data siswa berhasil dihapus', 'teacher' => $teacher], 200);
        }
        return redirect()->route('admin/teacher.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
